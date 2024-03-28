<?php

namespace app\controller;

use app\core\Route;
use app\core\Router;
use app\model\Product;

class SearchController extends AppController
{
	public function actionIndex()
	{
		if (!$this->ajax) exit();

		$q = $this->ajax['text'];
		$q = stripslashes(mb_strtolower($q));
		$q = '%' . $q . '%';

		$admin = in_array('/adminsc', parse_url($_SERVER['HTTP_REFERER']));

		$art = Product::query()
			->trashed($admin)
			->where('art', 'LIKE', $q)
			->where('instore', '>', 0)
			->select('name', 'slug', 'art', 'id', 'instore',)
			->take(20)
			->get();

		$name = Product::query()
			->trashed($admin)
			->where('name', 'LIKE', $q)
			->where('instore', '>', 0)
			->select('name', 'slug', 'art', 'id', 'instore',)
			->take(20)
			->get();

		$art = $art->toArray();
		$name = $name->toArray();

		$res = array_merge($art, $name);

		$this->exitJson(['found' => $res]);
	}
}
