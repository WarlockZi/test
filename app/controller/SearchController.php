<?php

namespace app\controller;

use app\model\Product;

class SearchController extends AppController
{
	public function actionIndex()
	{
		if (!$this->ajax) exit();

		$q = $this->ajax['text'];
		$q = stripslashes(mb_strtolower($q));
		$q = '%' . $q . '%';

		$art = Product::query()
			->where('art', 'LIKE', $q)
			->where('instore', '>', 0)
			->select('name', 'slug', 'art','id')
			->take(20)
			->get()
			->toArray();

		$name = Product::query()
			->where('name', 'LIKE', $q)
			->where('instore', '>', 0)
			->select('name', 'slug', 'art','id')
			->take(20)
			->get()
			->toArray();
		$res = array_merge($art, $name);

		$this->exitJson(['found' => $res]);
	}
}
