<?php


namespace app\Actions;


use app\controller\AppController;
use app\core\FS;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\Services\Logger\FileLogger;
use app\Services\Logger\ILogger;
use app\Services\XMLParser\LoadCategories;
use app\Services\XMLParser\LoadPrices;
use app\Services\XMLParser\LoadProducts;
use app\Storage\StorageDev;
use app\Storage\StorageImport;
use app\Storage\StorageLog;
use app\Storage\StorageXml;

class SyncActions extends AppController
{
	protected $importPath;
	protected $storage;
	protected $importFile;
	protected $offerFile;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $route;

	public function __construct($route, $logger)
	{
		$this->setStorage();
		$this->route = $route;
		$this->logger = $logger;

		$this->importFile = $this->storage::getFile('import0_1.xml');
		$this->offerFile = $this->storage::getFile('offers0_1.xml');
	}
	public function setStorage(){
//		$this->log = StorageLog::getFile('log.txt');
		$this->importPath = StorageImport::getPath();
		if ($_ENV['MODE'] === 'development') {
			$this->storage = StorageDev::class;
		} else {
			$this->storage = StorageImport::class;
		}
	}


	public function init()
	{
		if (isset($this->route->params['type'])) {
			if ($this->route->params['type'] === 'catalog') {
				if ($this->route->params['mode'] === 'checkauth') {
					$this->checkauth();
				} elseif ($this->route->params['mode'] === 'init') {
					$this->zip();
				} elseif ($this->route->params['mode'] === 'file') {
					$this->file();

					$time = '<br>+++' . date('H:i:s') . '<br>+++';
					$this->append($time);


				} elseif ($this->route->params['mode'] === 'import') {
					$this->import();
				}
			}
		}
	}

	public function import()
	{
		$this->trancate();

		if (is_readable($this->importFile)) {
			$this->LoadCategories();
			$this->LoadProducts();
		}

		if (is_readable($this->offerFile)) {
			$this->LoadPrices();
//			$this->append("<br>loaded = price<br>");
		}
		exit('success');
	}

	public function LoadCategories()
	{
		new LoadCategories($this->importFile, 'full',$this->logger);
	}

	public function LoadProducts()
	{
		new LoadProducts($this->importFile, 'full');
	}

	public function LoadPrices()
	{
		new LoadPrices($this->offerFile, 'full');
	}

	protected function checkauth()
	{
		$this->logReqest('checkauth');
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

		$this->append($text);

	}

	protected function append(string $text)
	{
		$time = date('H:i:s');
//		file_put_contents($this->log, $text . " - {$time} - ", FILE_APPEND | LOCK_EX);
	}

	public function parseImages()
	{
		$prods = Product::all();
		$uploads = ROOT . "\pic\product\uploads\\";
		$origin = 'C:\Users\v.voronik\Desktop\orig\\';
		$to = 'C:\Users\v.voronik\Desktop\new2\\';
		if (!is_dir($to)) mkdir($to);

		foreach ($prods as $prod) {
			$art = trim($prod->art);
			$file = FS::platformSlashes("$origin{$art}.jpg");
			$newfile = FS::platformSlashes("$to{$art}.jpg");
			if (is_file($file)) {
				rename($file, $newfile);
			}
		}
	}

	public function logshow()
	{
		$content = 'LOG<br>' . file_get_contents($this->log);
		if (isset($_POST['param'])) {
			$this->exitJson(['success' => true, 'content' => $content]);
		}
	}

	public function logclear()
	{
		file_put_contents($this->log, '');

		$content = StorageLog::getFileContent('log.txt');
		$this->exitJson(['success' => 'success', 'content' => $content]);
	}


	public function removeCategories()
	{
		Category::truncate();
//		$this->exitWithPopup('ok');
	}

	public function removeProducts()
	{
		Product::truncate();
//		$this->exitWithPopup('ok');
	}

	public function removePrices()
	{
		Price::truncate();
//		$this->exitWithPopup('ok');
	}

	public function trancate()
	{
		$this->removeCategories();
		$this->removeProducts();
		$this->removePrices();
//		$this->exitWithPopup('ok');
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
			new LoadCategories($this->importFile, 'part',false);
			new LoadProducts($this->importFile, 'part');

		}

		if (is_readable($this->offerFile)) {
			new LoadPrices($this->offerFile, 'part');
		}
		exit('success');
	}
}
