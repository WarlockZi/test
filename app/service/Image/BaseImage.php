<?php

namespace app\service\Image;

use app\service\Image\ImageProcessor\GDImageProcessor;
use app\service\Image\ImageProcessor\IImageProcessor;

class BaseImage
{
    protected IImageProcessor $processor;
    protected string $basePath;
    private string $noImage;
    protected array $acceptedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    protected array $types = [
        "image/jpg" => "jpg",
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
    ];
    protected int $maxHeight = 600;
    protected int $maxWidth = 600;
    protected int $quality = 60;
    protected int $maxThumbHeight = 300;
    protected int $maxThumbWidth = 300;

    public function __construct()
    {
        $this->setImageProcessor();
        $this->basePath = env('PIC_BASE_PATH');
        $this->noImage  = env('PIC_SERVICE') . "nophoto-min.jpg";
    }

    private function setImageProcessor(): void
    {
        if (extension_loaded('gd') && function_exists('gd_info')) {
            $this->processor = new GDImageProcessor();
        }
    }

    protected function getType(): string
    {
        if (empty($this->file->getMimeType())) throw new \Exception('Файл основной картинки товара не найдена');
        return $this->types[$this->file->getMimeType()];
    }
}
