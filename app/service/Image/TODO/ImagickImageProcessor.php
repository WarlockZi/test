<?php
namespace app\service\Image\TODO;
use app\service\Image\ImageProcessor\IImageProcessor;
use Exception;
use function app\service\Image\exif_imagetype;

class ImagickImageProcessor implements IImageProcessor{
    private $image;
    private $type;

    public function reduceQuality(int $quality = null): void
    {
        $quality      = $quality ?? $this->quality;
        $imageService = new ImagickService($this->getAbsolutePath());
        $q            = $imageService->img->getImageCompressionQuality();
        if ($q > $quality) {
            $imageService->img->setImageCompressionQuality($quality);
            $imageService->img->writeImage();
            $imageService->img->clear();
            $imageService->img->destroy();
        }
    }
    public function setImage(string $imagePath) {
        if (!file_exists($imagePath)) {
            throw new Exception("Image file not found");
        }

        $this->type = exif_imagetype($imagePath);

        $this->image = match ($this->type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($imagePath),
            IMAGETYPE_PNG => imagecreatefrompng($imagePath),
            IMAGETYPE_GIF => imagecreatefromgif($imagePath),
            default => throw new Exception("Unsupported image type"),
        };

    }

    public function createThumbnail($size = 200): static
    {
        return $this->resize($size, $size);
    }

    public function save(string $path, int $quality = 70): void
    {
        switch ($this->type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, $path, $quality);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image, $path);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image, $path);
                break;
        }

        imagedestroy($this->image);
    }

    public function output($quality = 70): void
    {
        header('Content-Type: ' . image_type_to_mime_type($this->type));

        switch ($this->type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, null, $quality);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image);
                break;
        }

        imagedestroy($this->image);
    }
    public function grayscale(): static
    {
        imagefilter($this->image, IMG_FILTER_GRAYSCALE);
        return $this;
    }
    public static function generateCaptcha($text, $width = 200, $height = 80) {
        $image = imagecreate($width, $height);

        $bgColor = imagecolorallocate($image, 240, 240, 240);

        $textColor = imagecolorallocate($image, 0, 0, 0);

        for ($i = 0; $i < 100; $i++) {
            $noiseColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($image, rand(0, $width), rand(0, $height), $noiseColor);
        }

        $fontSize = 20;
        $textBbox = imagettfbbox($fontSize, 0, 5, $text);
        $textWidth = $textBbox[2] - $textBbox[0];
        $textHeight = $textBbox[7] - $textBbox[1];

        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2 + $textHeight;

        imagettftext($image, $fontSize, 0, $x, $y, $textColor, 5, $text);

        return $image;
    }
}