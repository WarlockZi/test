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

		$q = stripslashes(mb_strtolower($this->ajax['text']));
		$q = addslashes('%' . $q . '%');

		$arr = Product::query()
			->where('name', 'LIKE', $q)
			->select('name', 'slug','art')
			->take(20)
			->get()
			->toArray()
		;

		$this->exitJson(['found' => $arr]);
	}
}
