<?php


namespace app\Domain\Product\Image;


use app\model\Product;
use app\Services\FS;

abstract class AbstractProductImage
{
    protected array $file;
    protected Product $product;
    protected array $types;
    protected array $acceptedTypes;
    protected string $relativePath;
    protected string $absolutePath;
    protected string $absoluteThumbPath;

    public function __construct(Product $product, array $file = [])
    {
        $this->product           = $product;
        $this->file              = $file;
        $this->relativePath      = '/Pic/product/Uploads/';
        $this->absolutePath      = FS::platformSlashes(ROOT . '/Pic/product/Uploads/');
        $this->absoluteThumbPath = ROOT . '/Pic/product/thumbs/';
        $this->acceptedTypes     = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $this->types             = [
            "image/jpg" => "jpg",
            "image/jpeg" => "jpeg",
            "image/png" => "png",
            "image/webp" => "webp",
        ];
    }


}