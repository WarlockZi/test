<?php

namespace app\service\Image\ImageProcessor;

interface IImageProcessor
{
    public function resize(int $width, int $height);
    public function setQuality(int $quality = 70): void;
    public function save(string $path, int $quality = 70): void;

}