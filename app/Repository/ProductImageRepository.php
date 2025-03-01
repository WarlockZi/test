<?php


namespace app\Repository;


use app\Storage\StorageProduct;

class ProductImageRepository
{
	private function __construct()
	{
		$this->storage = new StorageProduct();
	}

	public static $size = 1000000;

	public static $acceptedTypes = [
		'jpg', 'jpeg', 'png', 'webp', 'gif'
	];
	public static $types = [
		"image/png" => "png",
		"image/jpg" => "jpg",
		"image/jpeg" => "jpeg",
		"image/gif" => "gif",
		"image/webp" => "webp",
	];

	private function fileExists(array $file){
		return $this->storage->fileExists($file);

	}

	public function saveFile(array $file){
		if (!$this->fileExists($file)){
			$this->storage->saveFile($file);
		}
	}

	public function attachImage(){

	}




}