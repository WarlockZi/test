<?php

namespace app\service\Product;

use app\model\Product;
use app\service\Image\del\ProductImageService;

class ProductService
{
    private Product $product;

    public function __construct(
        private ProductImageService $imageService,
    )
    {
    }
}