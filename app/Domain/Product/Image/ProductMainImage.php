<?php


namespace app\Domain\Product\Image;


use app\model\Product;

class ProductMainImage extends AbstractProductImage
{
	public function __construct(Product $product, array $file = [])
	{
		parent::__construct($product, $file);
	}

	public function getRelativePath(): string
	{
		if ($this->file) {
			return $this->relativePath .
				$this->product->art .
				'.' .
				$this->getExtension();
		}

		foreach ($this->acceptedTypes as $type) {
			$fileName = $this->absolutePath .
				$this->product->art .
				'.' .
				$type;

			if (file_exists($fileName)) {
				return $this->relativePath .
					$this->product->art .
					'.' .
					$type;
			}
		}
		return '';
	}

	public function getAbsolutePath(): string
	{
		return
			$this->absolutePath .
			$this->product->art .
			'.' .
			$this->getExtension();
	}

	public function save(): void
	{
		move_uploaded_file($this->file['tmp_name'], $this->getAbsolutePath());
	}

	public function deletePreviousFile()
	{
		foreach ($this->acceptedTypes as $ext) {
			$fileName = $this->absolutePath . $this->product->art . '.' . $ext;
			if (file_exists($fileName)) {
				unlink($fileName);
			}
		}
	}


}