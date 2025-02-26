<?php

namespace app\Services;

use app\core\FS;
use app\model\Product;
use app\Services\ImageService\ImagickService;

class ProductImageService
{
    private string $relativePath = "/pic/product/uploads/";
    private string $absolutePath;
    private string $relNoImage = "/pic/srvc/nophoto-min.jpg";
    private string $absNoImage;
    private string $art;
    private array $extensions = ['jpg', 'jpeg', 'png'];

    public function __construct()
    {
        $this->absNoImage   = FS::platformSlashes(ROOT . $this->relNoImage);
        $this->absolutePath = FS::platformSlashes(ROOT . $this->relativePath);
    }

    public function getArt(Product $product): string
    {
        $art       = str_replace(['/', '//', '\\'], '_', $product->art);
        $this->art = trim(strip_tags($art));
        return $this->art;
    }

    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    public function getAbsolutePath(): string
    {
        return $this->absolutePath;
    }

    public function getImageRelativePath(Product $product): string
    {
        $art = $this->getArt($product);
        foreach ($this->extensions as $ext) {
            $relFile = $this->relativePath . $art . ".{$ext}";
            $file    = FS::platformSlashes(ROOT . $relFile);
            if (file_exists($file)) {
                return $relFile;
            }
        }
        return $this->relNoImage;
    }

    public function getImageAbsolutePath(Product $product): string
    {
        $art = $this->getArt($product);
        foreach ($this->extensions as $ext) {
            $relFile = $this->absolutePath . $art . ".{$ext}";
            $file    = FS::platformSlashes($relFile);
            if (file_exists($file)) {
                return $relFile;
            }
        }
        return '';
    }

    public function getRelativeImage(Product $product): string
    {
        return $this->getImageRelativePath($product) ?? $this->relNoImage;
    }

    public function getAbsoluteImage(Product $product): string
    {
        if ($this->getImageAbsolutePath($product)) {
            return $this->getAbsoluteImage($product);
        }
        return FS::platformSlashes(ROOT . $this->relNoImage);
    }

    protected function getPathWithExt($relOrAbs, $type = null): string
    {
        $type = $type ?? $this->getExtension();
        return $this->$relOrAbs .
            $this->art .
            '.' . $type;
    }

    public function getNoPhoto(): string
    {
        return $this->relNoImage;
    }

    public function getExtension(): string
    {
        if ($this->file) {
            preg_match('~\..{2,4}$~', $this->file['name'], $matches);
            return str_replace('.', '', $matches[0]);
        }
        return $this->getFromAcceptedTypes();
    }

    public function thumbnail()
    {
        $absPath = $this->getImageAbsolutePath();

        $webpName = $this->absoluteThumbPath . $this->art . '.webp';
        copy($absPath, $webpName);
        $ima = new ImagickService($webpName);
        $ima->img->setImageFormat("WEBP");
        $ima->thumbnail(
            $webpName,
            $this->maxThumbWidth,
            $this->maxThumbHeight,
            $this->quality,
        );

//		$ima->img->writeImage($webpName);
        $ima->img->clear();
        $ima->img->destroy();
    }

    protected function getFromAcceptedTypes()
    {
        foreach ($this->acceptedTypes as $type) {
            $fileName = $this->getPathWithExt('absolutePath', $type);

            if (file_exists($fileName)) {
                return $this->getPathWithExt('relativePath', $type);
            }
        }
        return '';
    }
}