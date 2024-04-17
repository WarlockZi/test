<?php


namespace app\Storage\Image\Product;


use app\Domain\Product\Image\AbstractProductImage;
use app\model\Product;

class ProductDetailImageStorage extends AbstractProductImage
{
	private $path;
	protected string $relativePath;

	public function __construct(array $file, Product $product)
	{
		parent::__construct($product, $file);
		$this->setImagePath();
	}

	public function setImagePath(): void
	{
		$this->path = realpath(ROOT . $this->relativePath);
	}


	public function save(): void
	{
		// TODO: Implement save() method.
	}

	public function getRelativePath(): string
	{
		// TODO: Implement getRelativePath() method.
	}

	public function getAbsolutePath(): string
	{
		// TODO: Implement getAbsolutePath() method.
	}
}