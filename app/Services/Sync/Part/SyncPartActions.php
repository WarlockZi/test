<?php


namespace app\Services\Sync\Part;


use AllowDynamicProperties;
use app\controller\AppController;
use app\core\Response;
use app\model\Category;
use app\Services\Sync\LoadCategories;
use app\Services\Sync\LoadPrices;
use app\Services\Sync\LoadProducts;
use app\Services\Sync\SyncRepository;
use app\Storage\{StorageDev, StorageImport, StorageLog};

#[AllowDynamicProperties] class SyncPartActions extends AppController
{
	protected $importPath;
	protected $storage;
	protected $importFile;
	protected $offerFile;
	protected $logger;
	protected $repo;
	public function __construct($route, $logger)
	{
		$this->setStorage();
		$this->route = $route;
		$this->logger = $logger;
		$this->repo = new SyncRepository();

		$this->importFile = $this->storage::getFile('import0_1.xml');
		$this->offerFile = $this->storage::getFile('offers0_1.xml');
	}
	public function setStorage()
	{
//		$this->log = StorageLog::getFile('log.txt');
		$this->importPath = StorageImport::getPath();
		if (DEV) {
			$this->storage = StorageDev::class;
		} else {
			$this->storage = StorageImport::class;
		}
	}
	/**
	 * @throws \Exception
	 */
	public function init()
	{
		if (!isset($this->route->params['type'])) throw new \Exception("Route param 'type' is empty");
		if (!$this->route->params['type'] === 'catalog') throw new \Exception("Route param 'type' is not correct");


		if ($this->route->params['mode'] === 'checkauth') {
			$this->checkauth();
		} elseif ($this->route->params['mode'] === 'init') {
			$this->zip();
		} elseif ($this->route->params['mode'] === 'file') {
			$this->file();

		} elseif ($this->route->params['mode'] === 'import') {
//			$this->trancate();
			$this->repo->softTrancate();
			$this->import();
		}
	}
	protected function partCreate($item, $level, $parent)
	{
		$found = Category::query()
			->where('1s_id', $item['1s_id'])
			->first();
		if ($found) {
			$found->delete();
			if ($level > 0 && isset($parent['id']))
				$item['category_id'] = $parent['id'];
			if ($level === 1) {
				$item['show_front'] = 1;
			}
			Category::create($item);
		}
	}
	public function import()
	{

		if (is_readable($this->importFile)) {
			$this->LoadCategories();
			$this->LoadProducts();
		}

		if (is_readable($this->offerFile)) {
			$this->LoadPrices();
		}
		exit('success');
	}
	public function LoadCategories()
	{
		new LoadCategories($this->importFile, $this->logger);
	}
	public function LoadProducts()
	{
		new LoadProducts($this->importFile, $this->logger);
	}
	public function LoadPrices()
	{
		new LoadPrices($this->offerFile, $this->logger);
	}
	protected function checkauth()
	{
		$this->log('checkauth');
		exit("success\ninc\n777777\n55fdsa55");
	}
	protected function zip()
	{
		$this->logReqest('init');
		exit("zip=no\nfile_limit=10000000");
	}
	protected function file()
	{
		$this->filename = $this->route->params['filename'];
		$this->rawPost = file_get_contents('php://input');
		file_put_contents($this->importPath . $this->filename, $this->rawPost);

		$this->logReqest('file');
		exit('success');
	}
	protected function getHeaders($str = '')
	{
		$headers = apache_request_headers();
		foreach ($headers as $header => $value) {
			$str .= "$header: $value <br />\n";
		}
		return $str;
	}
	protected function logReqest($func)
	{
		$text = '<br>--' . date("H:i:s") . "--{$func}<br>";
		if (isset($_GET)) {
			$text .= '$_GET - ' . json_encode($_GET) . '<br>';
		}

		$text .= 'headers -' . $this->getHeaders();
		if (isset($this->route->params['filename'])) {
			$text .= 'filename - ' . $filename = $this->route->params['filename'] . '<br>';
			$text .= $this->importPath . $filename;
		}

	}
	public function logshow()
	{
		$content = 'LOG<br>' . file_get_contents($this->log);
		if (isset($_POST['param'])) {
			Response::json(['success' => true, 'content' => $content]);
		}
	}
	public function logclear()
	{
		file_put_contents($this->log, '');

		$content = StorageLog::getFileContent('log.txt');
		Response::json(['success' => 'success', 'content' => $content]);
	}
	public function part()
	{
		if (isset($this->route->params['type'])) {
			if ($this->route->params['type'] === 'catalog') {
				if ($this->route->params['mode'] === 'checkauth') {
					$this->checkauth();
				} elseif ($this->route->params['mode'] === 'init') {
					$this->zip();
				} elseif ($this->route->params['mode'] === 'file') {
					$this->file();
//					$time = '<br>+++' . date('H:i:s') . '<br>+++';
//					$this->append($time);
				} elseif ($this->route->params['mode'] === 'import') {
					$this->partload();
				}
			}
		}
	}
	public function partload()
	{
		if (is_readable($this->importFile)) {
			new LoadCategories($this->importFile, 'part', false);
			new LoadProducts($this->importFile, 'part');

		}

		if (is_readable($this->offerFile)) {
			new LoadPrices($this->offerFile, 'part');
		}
		exit('success');
	}
}
