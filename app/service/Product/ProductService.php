<?php

namespace app\service\Product;

use app\model\Product;

class ProductService
{
    private Product $product;

    public function __construct()
    {
    }

    public function notFound($product): void
    {
        response()->view('product.notFound',
            compact('product'),
            404);
    }
}