<?php

namespace app\service\Image\del;

use app\model\Product;
use app\service\Fs\FS;

class ProductImageService
{
    private string $relativePath ='';
    private string $relNoImage = PIC_SERVICE . "nophoto-min.jpg";
    private string $absolutePath;
    private array $extensions = ['jpg', 'jpeg', 'png', 'webp'];

    public function __construct()
    {
        $this->relativePath= env("PIC_PRODUCT");
        $this->absolutePath = FS::platformSlashes(ROOT . $this->relativePath);
    }
    public function getImageRelativePath(Product $product): string
    {
        $path = $this->relativePath . $product->ownProperties->main_image;
        return is_readable(FS::platformSlashes(ROOT . $path))
            ? $path
            : $this->relNoImage;
    }
}