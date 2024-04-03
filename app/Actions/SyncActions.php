<?php


namespace app\Actions;


use app\controller\AppController;
use app\core\Route;
use app\Repository\SyncRepository;
use app\Storage\StorageDev;
use app\Storage\StorageImport;

class SyncActions extends AppController
{
	protected $importPath;
	protected $storage;
	protected $importFile;
	protected $offerFile;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $route;
	protected $logger;
	protected $repo;

	public function __construct(SyncRepository $repo, Route $route, $logger)
	{
		$this->setStorage();
		$this->repo = $repo;
		$this->route = $route;
		$this->logger = $logger;

		$this->importFile = $this->storage::getFile('import0_1.xml');
		$this->offerFile = $this->storage::getFile('offers0_1.xml');
	}

	public function setStorage()
	{
		$this->importPath = StorageImport::getPath();
		if ($_ENV['DEV'] == '1') {
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
			exit('success');
		}
	}

	private function importFilesExist(){
		if (!is_readable($this->importFile)) {
			$this->logger->write('Отсутстует файл importFile');
			return false;
		}
		if (!is_readable($this->offerFile)) {
			$this->logger->write('Отсутстует файл offerFile');
			return false;
		}
		return true;
	}

	public function load()
	{
		try {
			if (!$this->importFilesExist())exit('Отсутстуют импорт файлы');

			$this->repo->softTrancate();

			$this->repo->LoadCategories();
			$this->repo->LoadProducts();
			$this->repo->LoadPrices();

		} catch (\Exception $e) {
			exit(PHP_EOL . '---Ошибка загрузки: SyncActions---' . PHP_EOL . $e->getMessage() . PHP_EOL . $e);
		}
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
		$filename = $this->route->params['filename'];
		file_put_contents($this->importPath . $filename, file_get_contents('php://input'));

		$this->logReqest('file');
		exit('success');
	}

	protected function logReqest($func)
	{
		$text = '<br>--' . date("H:i:s") . "--{$func}<br>";
		if (isset($_GET)) {
			$text .= '$_GET - ' . json_encode($_GET) . '<br>';
		}

		if (isset($this->route->params['filename'])) {
			$text .= 'filename - ' . $filename = $this->route->params['filename'] . '<br>';
			$text .= $this->importPath . $filename;
		}
		$this->logger->write($text);
	}
}
