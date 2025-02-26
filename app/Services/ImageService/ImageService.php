<?php

namespace app\Services\ImageService;

abstract class ImageService implements IImage
{
	public $img;
	protected string $absPath;

	public function __construct(string $absPath)
	{
		$this->absPath = $absPath;
		$this->img = new \Imagick($this->absPath);
	}

	protected function isWider(\Imagick $image, int $newWidth)
	{
		$currentWidth = $image->getImageWidth();
		return $currentWidth > $newWidth ? $currentWidth : 0;
	}

	protected function isHeigher(\Imagick $image, int $newHeight)
	{
		$currentHeight = $image->getImageHeight();
		return $currentHeight > $newHeight ? $currentHeight : 0;
	}

	public function thumbnail(string $path, int $newWidth, int $newHeight, int $quality)
	{
		$img = new \Imagick($path);
		$currentWidth = $this->isWider($img, $newWidth);
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
