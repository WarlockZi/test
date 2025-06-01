<?php

namespace app\service\Product;

use app\model\Product;
use app\service\Image\ProductImageService;
use app\service\Image\TODO\ImagickService;

class ProductService
{
    private Product $product;
    private ProductImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ProductImageService();
    }


    private function deletePreviousFile(Product $product): void
    {
        $image   = $this->imageService->getRelativeImage($product);
        $noPhoto = $this->imageService->getNoPhoto();
        if ($image !== $noPhoto) {
            unlink($image);
        }
    }

    public static function productImg($col, $product, $field): string
    {
        $productImageService = new ProductImageService();
        $imgPath             = $productImageService->getRelativeImage($product);
        return "<img src='{$imgPath}' loading='lazy'>";
    }

    private function getRelativePath(): string
    {
        if ($this->file) {
            return $this->getPathWithExt('relativePath', $this->getExtension());
        }
        foreach ($this->acceptedTypes as $type) {
            $fileName = $this->getPathWithExt('absolutePath', $type);

            if (file_exists($fileName)) {
                return $this->getPathWithExt('relativePath', $type);
            }
        }
        return '';
    }

    public function getAbsolutePath(): string
    {
        if ($this->file) {
            return $this->getPathWithExt('absolutePath', $this->getExtension());
        }

        foreach ($this->acceptedTypes as $type) {
            $fileName = $this->getPathWithExt('absolutePath', $type);

            if (file_exists($fileName)) {
                return $fileName;
            }
        }
        return '';
    }

    public function reduceQuality(int $quality)
    {
        $imageService = new ImagickService($this->getAbsolutePath());
        $q            = $imageService->img->getImageCompressionQuality();
        if ($q > $quality) {
            $imageService->img->setImageCompressionQuality($quality);
            $imageService->img->writeImage();
            $imageService->img->clear();
            $imageService->img->destroy();
        }
    }

    //    public static function baseIsShippable($col, $product): string
//    {
//        if (!isset($product->baseUnit->pivot)) return '';
//        $baseIsShippable = $product->baseUnit->pivot->is_shippable;
//        $checked         = $baseIsShippable ? "checked" : '';
//        return "<input type='checkbox' {$checked} data-func='changeBaseIsShippable' data-1sid='{$product['1s_id']}'>";
//    }

//    public static function changeBaseIsShippable(array $req): void
//    {
//
//    }
}