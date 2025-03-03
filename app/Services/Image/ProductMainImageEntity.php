<?php


namespace app\Domain\Product\Image;


use app\model\Product;
use app\Services\ImageService\ImagickService;

class ProductMainImageEntity extends AbstractProductImage
{
	protected string $art;
	protected ImagickService $imagickService;
	protected $thumbDir = 'thumbs' . DIRECTORY_SEPARATOR;
	protected $maxImgHeight = 700;
	protected $maxImgWidth = 700;
	protected $quality = 60;
	protected $maxThumbHeight = 300;
	protected $maxThumbWidth = 300;
	protected $fullPath;

	public function __construct(Product $product, array $file = [])
	{
		parent::__construct($product, $file);
		$this->art = $this->prepareArticle($this->product->art);
		$this->fullPath = $this->art . '.' . $this->getExtension();
	}

	protected function getPathWithExt($relOrAbs, $type = null): string
	{
		$type = $type ?? $this->getExtension();
		return $this->$relOrAbs .
			$this->art .
			'.' . $type;
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

	public function thumbnail()
	{
		$absPath = $this->getAbsolutePath();

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

	public function save(): void
	{
		$absPath = $this->getAbsolutePath();
		move_uploaded_file($this->file['tmp_name'], $absPath);

		$this->reduceQuality($this->quality);

	}

	public function deletePreviousFile(): void
	{
		foreach ($this->acceptedTypes as $ext) {
			$fileName = $this->absolutePath . $this->product->art . '.' . $ext;
			if (file_exists($fileName)) {
				unlink($fileName);
			}
		}
	}
}
