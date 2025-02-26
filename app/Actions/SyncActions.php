<?php


namespace app\Actions;


use app\controller\AppController;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\Actions\XMLParser\LoadCategories;
use app\Actions\XMLParser\LoadPrices;
use app\Actions\XMLParser\LoadProducts;
use app\Storage\{StorageDev, StorageImport};

class SyncActions extends AppController
{
	protected $importPath;
	protected $storage;
	protected $importFile;
	protected $offerFile;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $route;
	protected $logger;

	public function __construct($route, $logger)
	{
		$this->setStorage();
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

	public function load()
	{
		try {
			$this->trancate();
			if (!is_readable($this->importFile)) exit('Отсутстует файл importFile');

			$this->LoadCategories();
			$this->LoadProducts();

			if (!is_readable($this->offerFile)) exit('Отсутстует файл offerFile');

			$this->LoadPrices();

		} catch (\Exception $e) {
			exit('Ошибка загрузки: ' . $e);
		}
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

	public function removeCategories()
	{
		Category::truncate();
	}

	public function removeProducts()
	{
		Product::truncate();
	}

	public function removePrices()
	{
		Price::truncate();
	}

	public function softTrancate()
	{
		$this->removeCategories();
		$this->removeProducts();
		$this->removePrices();
	}

	public function trancate()
	{
		$this->removeCategories();
		$this->removeProducts();
		$this->removePrices();
	}



}
