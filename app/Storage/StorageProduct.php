<?php


namespace app\Storage;


class StorageProduct
{
	public $productImagesPath;
	public $relativePath;

	public function __construct()
	{
//		parent::__construct();
		$this->relativePath = '/pic/';
		$this->productImagesPath = 'product/uploads/';
	}

	public function getImagePath()
	{
		return $this->path . $this->productImagesPath;
	}

	protected function getMainImagePath(array $file)
	{
		return ROOT . $this->getImagePath() . $file['name'];
	}

//	public function saveMainImage(array $file, string $art): void
//	{
//		$path = $this->getMainImagePath($file);
//		$this->saveFile($path, $file);
//	}

	public function saveFile(string $path, array $file)
	{
		if ($file['size'] > 2000000)
			exit(json_encode(['error' => "file {$file['name']} - too big size {$file['size']}"]));
		return move_uploaded_file($file['tmp_name'], $path);
	}

	public function fileExists(array $file)
	{

	}
}