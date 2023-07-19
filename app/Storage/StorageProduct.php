<?php


namespace app\Storage;


class StorageProduct extends StorageImg
{
	public $productImagesPath;
	public $relativePath;

	public function __construct()
	{
		parent::__construct();
		$this->productImagesPath = 'product/uploads/';
		$this->relativePath = '/pic/';
	}

	public function getImagePath()
	{
		return $this->path . $this->productImagesPath;
	}

	public function saveFile(string $path, $file)
	{
		if ($file['size'] > 2000000)
			exit(json_encode(['error' => "file {$file['name']} - too big size {$file['size']}"]));
		return move_uploaded_file($file['tmp_name'], $path);
	}

}