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
use app\Storage\PicStorage;
use app\Storage\XmlStorage;

class XmlController extends AppController
{
	public $model = xml::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		if ($_POST) {
			$file = FS::platformSlashes(ROOT . '/app/Storage/xml/' . $_POST['file'] . '.xml');
			$readable = is_readable($file);
			if ($_POST['action'] === 'loadProducts' && $readable) {
				new LoadProducts($file);
			} elseif ($_POST['action'] === 'loadProductsOffer' && $readable) {
				new LoadProductsOffer($file);
			} elseif ($_POST['action'] === 'loadCategories' && $readable) {
				new LoadCategories($file);
			} elseif ($_POST['action'] === 'loadPrices' && $readable) {
				new LoadPrices($file);


			} elseif ($_POST['action'] === 'parseImages') {
				self::parseImages();
			} elseif ($_POST['action'] === 'removePrices') {
				Price::truncate();
			} elseif ($_POST['action'] === 'removeCategories') {
				Category::truncate();
			} elseif ($_POST['action'] === 'removeProducts') {
				Product::truncate();
			}
		}
		$storage = new XmlStorage;
		$files = $storage->getFiles();
		$this->set(compact('files'));

	}

	public function parseImages()
	{
		$prods = Product::all();

		$uploads = ROOT . "\pic\product\uploads\\";
		$origin = 'C:\Users\v.voronik\Desktop\origin\\';
		$to = 'C:\Users\v.voronik\Desktop\new1\\';
		if (!is_dir($to)) mkdir($to);

		foreach ($prods as $prod){
			$art = trim($prod->art);

			$file = FS::platformSlashes("$origin{$art}.jpg");
			$newfile = FS::platformSlashes("$to{$art}.jpg");
			if (is_file($file)){
				rename($file, $newfile);
			}
		}
	}

	public function actionIncread(){
		$content = PicStorage::getFileContent('integration.txt');
		$this->set(compact('content'));
	}

	public function actionIncClear(){
		$file= PicStorage::getFile('integration.txt');
		file_put_contents($file,'');

		$content = PicStorage::getFileContent('integration.txt');
		$this->set(compact('content'));
	}



}


