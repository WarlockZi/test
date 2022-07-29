<?php

namespace app\controller;

use app\model\Product;

class ProductController Extends AppController
{

	protected $modelName = Product::class;
	protected $model;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->model = new $this->modelName;
	}


}
