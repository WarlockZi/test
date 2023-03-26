<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Category;
use app\model\Product;
use app\Services\XMLParser\Parser;
use app\Services\XMLParser\Parser2;
use app\Services\XMLParser\XMLParser;
use app\Services\XMLParser\XMLParser3;


class XmlController extends AppController
{
  public $model = xml::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function actionIndex()
  {
    $_POST['file'] = 'g';
    $parser = new Parser($_POST['file']);
    Product::truncate();
    Category::truncate();
    $parser->loadCategories();
    $parser->loadProducts();

    $f = Product::count();
  }
}


