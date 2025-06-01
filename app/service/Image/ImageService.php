<?php

namespace app\service\Image;

use Imagick;
use ImagickException;

class ImageService
{
    public function __construct(
        protected Imagick $image,
        private string    $absPath = '',
    )
    {
    }

    /**
     * @throws ImagickException
     */
    public function setImage(string $absPath): void
    {
        $this->absPath = rtrim($absPath, '/');
        $this->image = new \Imagick($this->absPath);
    }

    /**
     * @throws ImagickException
     */
    protected function isWider(\Imagick $image, int $newWidth): int
    {
        $currentWidth = $image->getImageWidth();
        return $currentWidth > $newWidth ? $currentWidth : 0;
    }

    /**
     * @throws ImagickException
     */
    protected function isHeigher(\Imagick $image, int $newHeight): int
    {
        $currentHeight = $image->getImageHeight();
        return $currentHeight > $newHeight ? $currentHeight : 0;
    }

    /**
     * @throws ImagickException
     */
    public function reduceQuality(int $quality): bool
    {
        $this->image->setCompressionQuality($quality);
        return $this->image->writeImage($this->absPath);
    }
}
