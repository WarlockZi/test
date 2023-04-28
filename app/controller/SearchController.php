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
			->select('name', 'slug', 'art')
			->take(20)
			->get()
			->toArray();

		$arr = Product::query()
			->where('name', 'LIKE', $q)
			->where('instore', '>', 0)
			->select('name', 'slug', 'art')
			->take(20)
			->get()
			->toArray();
		$res = array_merge($art, $arr);

		$this->exitJson(['found' => $res]);
	}
}
