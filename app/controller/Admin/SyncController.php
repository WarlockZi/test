<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\model\Unit;
use app\Services\XMLParser\LoadCategories;
use app\Services\XMLParser\LoadPrices;
use app\Services\XMLParser\LoadProducts;
use app\Services\XMLParser\LoadProductsOffer;
use app\Storage\StorageImport;
use app\Storage\StorageLog;
use app\Storage\StorageXml;

class SyncController extends AppController
{
	public $model = xml::class;

	protected $log;
	protected $rawPost;
	protected $filename;
	protected $importPath;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';

	public function __construct()
	{
		parent::__construct();
		$this->log = StorageLog::getFile('log.txt');
		$this->importPath = StorageImport::getPath();
	}

	public function actionIncread()
	{
		$content = file_get_contents($this->log);
		if (isset($_POST['param'])) {
			$this->exitJson(['success' => true, 'content' => $content]);
		}
		$button = FS::getFileContent($this->viewPath . 'button.php');
		$this->set(compact('content', 'button'));
	}

	public function actionIncClear()
	{
		file_put_contents($this->log, '');

		$content = StorageLog::getFileContent('log.txt');
		$this->exitJson(['success' => 'success', 'content' => $content]);
	}

	public function trancate()
	{
		Category::truncate();
		Product::truncate();
		Price::truncate();
//			Unit::truncate();
	}

	public function actionIncTruncate()
	{
		$this->trancate();
		$count = Category::count();
		$this->exitJson(['success' => 'success', 'content' => 'Удалены категории, товары, цены Количество кат - '.$count]);
	}

	public function actionInit()
	{
		if (isset($this->route->params['type'])) {
			if ($this->route->params['type'] === 'catalog') {
				if ($this->route->params['mode'] === 'checkauth') {
					$this->checkauth();
				} elseif ($this->route->params['mode'] === 'init') {
					$this->init();
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
		if ($_ENV['MODE'] === 'development') {
			$storage = StorageXml::class;
		} else {
			$storage = StorageImport::class;
		}
			$file = $storage::getFile('import0_1.xml');

		if (is_readable($file)) {
			new LoadCategories($file);
			new LoadProducts($file);
			$this->append("<br>loaded = {cat and prod}<br>");
		}
		$file = $storage::getFile('offers0_1.xml');

		if (is_readable($file)) {
			new LoadPrices($file);
			$this->append("<br>loaded = price<br>");
		}
		exit('success');
	}

	protected function checkauth()
	{
		$this->logReqest('checkauth');
		exit("success\ninc\n777777\n55fdsa55");
	}

	protected function init()
	{
		$this->logReqest('init');
		exit("zip=no\nfile_limit=10000000");
	}

	protected function file()
	{
		$this->filename = $this->route->params['filename'];
		$this->rawPost = file_get_contents('php://input');

		if (!is_dir($this->importPath)){
			$res = FS::makePath($this->importPath);
		}
		file_put_contents($this->importPath . $this->filename, $this->rawPost);

		$this->logReqest('file');
		exit('success');
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
		file_put_contents($this->log, $text . " - {$time} - ", FILE_APPEND | LOCK_EX);
	}

	protected function getHeaders($str = '')
	{
		$headers = apache_request_headers();
		foreach ($headers as $header => $value) {
			$str .= "$header: $value <br />\n";
		}
		return $str;
	}

	public function parseImages()
	{
		$prods = Product::all();

		$uploads = ROOT . "\pic\product\uploads\\";
		$origin = 'C:\Users\v.voronik\Desktop\origin\\';
		$to = 'C:\Users\v.voronik\Desktop\new1\\';
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

	public function actionLoad()
	{
		$this->import();
	}

}


