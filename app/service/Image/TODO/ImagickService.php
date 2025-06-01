<?php

namespace app\service\Image\TODO;

class ImagickService
{

    public function __construct(
        protected \Imagick     $imagick,
        public array     $img = [],
        protected string $absPath = '',
    )
    {
//        $this->img     = new \GD($this->absPath);
    }

    protected function isWider(\Imagick $image, int $newWidth): int
    {
        $currentWidth = $image->getImageWidth();
        return $currentWidth > $newWidth ? $currentWidth : 0;
    }

    protected function isHeigher(\Imagick $image, int $newHeight): int
    {
        $currentHeight = $image->getImageHeight();
        return $currentHeight > $newHeight ? $currentHeight : 0;
    }

    public function thumbnail(string $path, int $newWidth, int $newHeight, int $quality): string
    {
        $img           = new \Imagick($path);
        $currentWidth  = $this->isWider($img, $newWidth);
        $currentHeight = $this->isHeigher($img, $newHeight);
        if (!$currentWidth && !$currentHeight) return 'smaller';

        if ($currentWidth) {
            $img->resizeImage($newWidth, 0, \Imagick::FILTER_LANCZOS, 0);
        } else {
            $img->resizeImage(0, $newHeight, \Imagick::FILTER_LANCZOS, 0);
        }
        $img->setCompressionQuality($quality);
        $img->writeImage($path);

        return 'resized';
    }


    public function reduceQuality(int $quality): bool
    {
        $this->img->setCompressionQuality($quality);
        return $this->img->writeImage($this->absPath);
    }
}
