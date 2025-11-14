<?php
namespace app\service\Image\ImageProcessor;
class ImageOptimizer {
    private $quality;
    private $maxWidth;
    private $maxHeight;

    public function __construct($quality = 30, $maxWidth = null, $maxHeight = null) {
        $this->quality = $quality;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    public function optimize($sourcePath, $destinationPath = null): bool
    {
        if (!$destinationPath) {
            $destinationPath = $sourcePath;
        }

        $imageInfo = getimagesize($sourcePath);
        $mimeType = $imageInfo['mime'];

        // Create image resource
        $image = $this->createImageResource($sourcePath, $mimeType);
        if (!$image) return false;

        // Resize if needed
        if ($this->maxWidth || $this->maxHeight) {
            $image = $this->resizeImage($image);
        }

        // Save optimized image
        $result = $this->saveImage($image, $destinationPath, $mimeType);
        imagedestroy($image);

        return $result;
    }

    private function createImageResource($path, $mimeType) {
        switch($mimeType) {
            case 'image/jpeg': return imagecreatefromjpeg($path);
            case 'image/png': return imagecreatefrompng($path);
            case 'image/gif': return imagecreatefromgif($path);
            default: return false;
        }
    }

    private function resizeImage($image) {
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        $newWidth = $originalWidth;
        $newHeight = $originalHeight;

        if ($this->maxWidth && $originalWidth > $this->maxWidth) {
            $ratio = $this->maxWidth / $originalWidth;
            $newWidth = $this->maxWidth;
            $newHeight = $originalHeight * $ratio;
        }

        if ($this->maxHeight && $newHeight > $this->maxHeight) {
            $ratio = $this->maxHeight / $newHeight;
            $newHeight = $this->maxHeight;
            $newWidth = $newWidth * $ratio;
        }

        if ($newWidth == $originalWidth && $newHeight == $originalHeight) {
            return $image;
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0,
            $newWidth, $newHeight, $originalWidth, $originalHeight);

        imagedestroy($image);
        return $newImage;
    }

    private function saveImage($image, $path, $mimeType) {
        switch($mimeType) {
            case 'image/jpeg':
                return imagejpeg($image, $path, $this->quality);
            case 'image/png':
                $pngQuality = 9 - round(($this->quality / 100) * 9);
                return imagepng($image, $path, $pngQuality);
            case 'image/gif':
                return imagegif($image, $path);
            default:
                return false;
        }
    }
}