<?php

namespace app\controller;

use app\core\Route;
use app\core\Router;
use app\model\Product;

class SearchController extends AppController
{

	protected function addTrashed($query, $admin)
	{
		if ($admin) {
			$query->withTrashed();
			$query->select('name', 'slug', 'art', 'id', 'instore','deleted_at');
			return $query;
		}
		return $query->select('name', 'slug', 'art', 'id', 'instore',);
	}

	public function actionIndex()
	{
		if (!$this->ajax) exit();

		$q = $this->ajax['text'];
		$q = stripslashes(mb_strtolower($q));
		$q = '%' . $q . '%';

		$admin = in_array('/adminsc', parse_url($_SERVER['HTTP_REFERER']));

		$query = Product::query();
		$query = $this->addTrashed($query, $admin);

		$art = $query
			->where('art', 'LIKE', $q)
			->where('instore', '>', 0)

			->take(20)
			->get();

		$name = $query
			->where('name', 'LIKE', $q)
			->where('instore', '>', 0)
//			->select('name', 'slug', 'art', 'id', 'instore',)
			->take(20)
			->get();

		$art = $art->toArray();
		$name = $name->toArray();

		$res = array_merge($art, $name);

		$this->exitJson(['found' => $res]);
	}
}
