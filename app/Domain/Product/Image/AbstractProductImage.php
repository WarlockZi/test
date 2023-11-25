<?php


namespace app\Domain\Product\Image;


use app\model\Product;

abstract class AbstractProductImage
{
	protected array $types = [
		"image/jpg" => "jpg",
		"image/jpeg" => "jpeg",
		"image/png" => "png",
		"image/webp" => "webp",
		"image/gif" => "gif",
	];
	protected array $acceptedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
	protected string $relativePath = '/pic/product/uploads/';
	protected string $absolutePath = ROOT . '/pic/product/uploads';
	protected array $file;
	protected Product $product;

	public function __construct(Product $product, array $file=[])
	{
		$this->file = $file;
		$this->product = $product;
		$this->absolutePath = realpath($this->absolutePath).DIRECTORY_SEPARATOR;
	}

	public function getExtension(): string
	{
		return $this->types[$this->file['type']];
	}

	abstract public function save(): void;

	abstract public function getRelativePath(): string;

	abstract public function getAbsolutePath(): string;

}