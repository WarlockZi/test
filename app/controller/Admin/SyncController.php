<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\Services\XMLParser\LoadCategories;
use app\Services\XMLParser\LoadPrices;
use app\Services\XMLParser\LoadProducts;
use app\Services\XMLParser\LoadProductsOffer;
use app\Storage\Storage1c;
use app\Storage\StorageImport;
use app\Storage\StorageLog;

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
					sleep(20);
					$time = '<br>+++'.date('H:i:s').'<br>+++';
					$this->append($time);
					$this->load();

				} elseif ($this->route->params['mode'] === 'import') {
//					$this->import();
				}
			}
		}
	}

	protected function load()
	{
		$file = StorageImport::getFile('import0_1.xml') ;
		$readable = is_readable($file);
		$time = "<br>readable = {$readable}<br>";
		$this->append($time);
		if ($readable) {
			Category::truncate();
			Product::truncate();
			$trunkate = "<br>trunkate = {true}<br>";
			$this->append($trunkate);
			new LoadCategories($file);
			new LoadProducts($file);
		}
		$file = StorageImport::getFile('offers0_1.xml');
		$readable = is_readable($file);
		if ($readable) {
			Price::truncate();
			new LoadPrices($file);
			new LoadProductsOffer($file);
		}
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
		$filename = $this->filename = $this->route->params['filename'];
		$this->rawPost = file_get_contents('php://input');
		file_put_contents($this->importPath . $filename, $this->rawPost);

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
		if (isset($_POST)) {
			$text .= '$_POST - ' . json_encode($_POST) . '<br>';
		}

		$text .= 'headers -' . $this->getHeaders();
		$text .= $this->filename;
		$this->append($text);
//		$text .= $this->rawPost;
	}

	protected function append(string $text){
		file_put_contents($this->log, $text, FILE_APPEND);
	}
	protected function getHeaders($str = '')
	{
		$headers = apache_request_headers();
		foreach ($headers as $header => $value) {
			$str .= "$header: $value <br />\n";
		}
		return $str;
	}
	protected function import()
	{
		exit('success');
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
//	public function actionIndex()
//	{
//		if ($_POST) {
//			$file = FS::platformSlashes(ROOT . '/app/Storage/xml/' . $_POST['file'] . '.xml');
//			$readable = is_readable($file);
//			if ($_POST['action'] === 'loadProducts' && $readable) {
//				new LoadProducts($file);
//			} elseif ($_POST['action'] === 'loadProductsOffer' && $readable) {
//				new LoadProductsOffer($file);
//			} elseif ($_POST['action'] === 'loadCategories' && $readable) {
//				new LoadCategories($file);
//			} elseif ($_POST['action'] === 'loadPrices' && $readable) {
//				new LoadPrices($file);
//
//
//			} elseif ($_POST['action'] === 'parseImages') {
//				self::parseImages();
//			} elseif ($_POST['action'] === 'removePrices') {
//				Price::truncate();
//			} elseif ($_POST['action'] === 'removeCategories') {
//				Category::truncate();
//			} elseif ($_POST['action'] === 'removeProducts') {
//				Product::truncate();
//			}
//		}
//		$storage = new StorageXml;
//		$files = $storage->getFiles();
//		$this->set(compact('files'));
//
//	}


}


