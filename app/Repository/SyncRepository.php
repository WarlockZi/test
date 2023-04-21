<?php


namespace app\Repository;


use app\core\FS;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\Services\XMLParser\LoadCategories;
use app\Services\XMLParser\LoadPrices;
use app\Services\XMLParser\LoadProducts;
use app\Storage\StorageImport;
use app\Storage\StorageLog;
use app\Storage\StorageXml;

class SyncRepository
{
	protected $log;
	protected $importPath;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $route ;

	public function __construct($route)
	{
		$this->log = StorageLog::getFile('log.txt');
		$this->importPath = StorageImport::getPath();
		$this->route = $route;
	}


	public function part()
	{

	}

	public function partload()
	{

	}

	public function incClear()
	{
		file_put_contents($this->log, '');

		$content = StorageLog::getFileContent('log.txt');
		$this->exitJson(['success' => 'success', 'content' => $content]);
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

		if ($_ENV['MODE'] === 'development') {
			$storage = StorageXml::class;
		} else {
			$storage = StorageImport::class;
		}
		$file = $storage::getFile('import0_1.xml');

		if (is_readable($file)) {
			new LoadCategories($file);
			new LoadProducts($file);

		}
		$file = $storage::getFile('offers0_1.xml');
		if (is_readable($file)) {
			new LoadPrices($file);
			$this->append("<br>loaded = price<br>");
		}
		exit('success');
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


	public function read()
	{
		$content = file_get_contents($this->log);
		if (isset($_POST['param'])) {
			$this->exitJson(['success' => true, 'content' => $content]);
		}
		$button = FS::getFileContent($this->viewPath . 'button.php');
		return [$content, $button];
	}

	public function removeCategories(){
		Category::truncate();
	}

	public function removeProducts(){
		Product::truncate();
	}
	public function removePrices(){
		Price::truncate();
	}

	public function trancate()
	{
		$this->removeCategories();
		$this->removeProducts();
		$this->removePrices();
//			Unit::truncate();
	}
}
