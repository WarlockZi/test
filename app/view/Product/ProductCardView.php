<?php

namespace app\view\Product;

use app\model\Product;
use app\Repository\ProductRepository;

class ProductCardView
{
	public $modelName = Product::class;
	public $model = 'product';

	public static function getCard($slug)
	{
		return ProductRepository::getCard($slug);
	}

}
