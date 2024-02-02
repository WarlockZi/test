<?php


namespace app\Domain\Product\Image;


use app\core\FS;
use app\model\Product;

abstract class AbstractProductImage
{
	protected array $file;
	protected Product $product;
	protected array $types;
	protected array $acceptedTypes;
	protected string $relativePath;
	protected string $absolutePath;
	protected string $absoluteThumbPath;

	public function __construct(Product $product, array $file = [])
	{
		$this->product = $product;
		$this->file = $file;
		$this->relativePath = '/pic/product/uploads/';
		$this->absolutePath = FS::platformSlashes(ROOT . '/pic/product/uploads/');
		$this->absoluteThumbPath = ROOT . '/pic/product/thumbs/' ;
		$this->acceptedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
		$this->types = [
			"image/jpg" => "jpg",
			"image/jpeg" => "jpeg",
			"image/png" => "png",
			"image/webp" => "webp",
			"image/gif" => "gif",
		];
	}

	public function getExtension(): string
	{
		return $this->file
			? $this->types[$this->file['type']]
			: $this->getFromAcceptedTypes();
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

	protected function prepareArticle(string $art): string
	{
		$art = str_replace(['/', '//', '\\'], '_', $art);
		return trim(strip_tags($art));
	}

	public function getRelativePath(): string
	{
		if ($this->file) {
			return $this->getPathWithExt('relativePath');
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
			return $this->getPathWithExt('absolutePath');
		}

		foreach ($this->acceptedTypes as $type) {
			$fileName = $this->getPathWithExt('absolutePath', $type);

			if (file_exists($fileName)) {
				return $fileName;
			}
		}
		return '';
	}

	abstract public function save(): void;

	private function getPathWithExt(string $string, string $type = ''): string
	{
		return $this->$string.$this->art.'.'.$type;
	}
}