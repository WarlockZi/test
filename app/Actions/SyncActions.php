<?php


namespace app\Actions;


use app\controller\AppController;
use app\core\Route;
use app\Repository\SyncRepository;

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

	public function __construct(SyncRepository $repo, Route $route)
	{
		$this->repo = $repo;
		$this->route = $route;
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
			$this->repo->softTrancate();
			if (!is_readable($this->importFile)) exit('Отсутстует файл importFile');

			$this->repo->LoadCategories();
			$this->repo->LoadProducts();

			if (!is_readable($this->offerFile)) exit('Отсутстует файл offerFile');

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
