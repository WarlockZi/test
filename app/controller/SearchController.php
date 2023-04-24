<?php

namespace app\controller;

use app\core\App;
use app\model\Product;
use app\view\View;

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
			->select('name', 'slug','art')
			->take(20)
			->get()
			->toArray()
		;

		$arr = Product::query()
		->where('name', 'LIKE', $q)
		->select('name', 'slug','art')
		->take(20)
		->get()
		->toArray()
	;
		$res = array_merge($art,$arr);

		$this->exitJson(['found' => $res]);
	}
}
