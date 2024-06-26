<?php

namespace app\Services;

use app\core\Response;
use app\model\Product;
use app\model\ProductUnit;

class ProductService
{
    private Product $product;
    private ProductImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ProductImageService();
    }

    public static function changeBaseIsShippable(array $req): void
    {
        $product1sId = Product::find($req['id'])['1s_id'];
        $pu = ProductUnit::query()
            ->where('product_1s_id', $product1sId)
            ->where('is_base', 1)
            ->where('multiplier', 1)
            ->first()
            ;
        $pu->base_is_shippable = (int)$req['checked'];
        $pu->is_shippable = (int)$req['checked'];
        $pu->save();
        Response::exitJson(['popup' => 'ok']);
    }

    public function saveMainImage(array $file, Product $product): string
    {
        $this->deletePreviousFile($product);
        $absPath = $this->imageService->getAbsolutePath();

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $art = $this->imageService->getArt($product);
        $name = $art . ".{$extension}";

        $uploaded_file = $file['tmp_name'];
        $destination_path = $absPath . $name;

        if (move_uploaded_file($uploaded_file, $destination_path)) {
            return $this->imageService->getRelativeImage($product);
        }
        return '';
//		$mainImage->thumbnail();
    }

    public static function baseIsShippable($col, $product): string
    {
        $baseIsShippable = $product->baseUnit->pivot->base_is_shippable;
        $checked = $baseIsShippable ? "checked" : '';
        return "<input type='checkbox' {$checked} data-func='changeBaseIsShippable'>";
    }

    private function deletePreviousFile(Product $product): void
    {
        $image = $this->imageService->getRelativeImage($product);
        $noPhoto = $this->imageService->getNoPhoto();
        if ($image !== $noPhoto) {
            unlink($image);
        }
    }

    public static function productImg($col, $product, $field): string
    {
        $productImageService = new ProductImageService();
        $imgPath = $productImageService->getRelativeImage($product);
        return "<img src='{$imgPath}'class='img'><img/>";
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
        $q = $imageService->img->getImageCompressionQuality();
        if ($q > $quality) {
            $imageService->img->setImageCompressionQuality($quality);
            $imageService->img->writeImage();
            $imageService->img->clear();
            $imageService->img->destroy();
        }
    }
}