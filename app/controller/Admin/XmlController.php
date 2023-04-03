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
use app\Services\XMLParser\Parser;

//use app\Services\XMLParser\Parser2;
//use app\Services\XMLParser\XMLParser;
//use app\Services\XMLParser\XMLParser3;
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
				$parser = new LoadProducts($file);
			} elseif ($_POST['action'] === 'loadCategories' && $readable) {
				$parser = new LoadCategories($file);
			} elseif ($_POST['action'] === 'loadPrices' && $readable) {
				$parser = new LoadPrices($file);


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
//    $files = $storage->getFileNames();
		$this->set(compact('files'));

	}

	public function actionLoadProducts()
	{

	}

	public function actionLoadCategories()
	{
	}

	public function actionTruncateProducts()
	{

	}

	public function actionTruncateCategories()
	{
	}
}


