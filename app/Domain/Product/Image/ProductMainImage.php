<?php


namespace app\Domain\Product\Image;


use app\model\Product;

class ProductMainImage extends AbstractProductImage
{
	protected string $art;

	public function __construct(Product $product, array $file = [])
	{
		parent::__construct($product, $file);
		$this->art = $this->getFilenameFromArt($this->product->art);
	}

	protected function getPathWithExt(string $relOrAbs): string
	{
		return $this->$relOrAbs .
			$this->art .
			'.' . $this->getExtension();
	}
	protected function getPathWithType($relOrAbs, $type): string
	{
		return $this->$relOrAbs .
			$this->art .
			'.' . $type;
	}
	protected function getFilenameFromArt(string $art): string
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
			$fileName = $this->getPathWithType('relativePath', $type);

			if (file_exists($fileName)) {
				return $fileName;
			}
		}
		return '';
	}

	public function getAbsolutePath(): string
	{
		if ($this->file) {
			return $this->absolutePath .
				$this->art .
				'.' . $this->getExtension();
		}

		foreach ($this->acceptedTypes as $type) {
			$fileName = $this->absolutePath .
				$this->art .
				'.' . $type;

			if (file_exists($fileName)) {
				return $fileName;
			}
		}
		return '';
	}

	public function save(): void
	{
		move_uploaded_file($this->file['tmp_name'], $this->getAbsolutePath());
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
