<?php

namespace app\controller;

use app\model\Illuminate\Image;
use app\Repository\ImageRepository;

class ImageController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);

	}

	private function checkSize($size)
	{
		if ($size > 1000000) {
			$this->exitWithPopup('Файл слишком большой');
		}
	}

	private function checkType($type)
	{
		$types = [
			"image/png",
			"image/jpg",
			"image/jpeg",
			"image/gif",
		];

		if (!in_array($type, $types)) {
			$this->exitWithPopup('Файл должен быть png, jpg, jpeg, gif');
		};
	}

	public function actionCreate()
	{
	}


	public static function move_uploaded_file($img, $file)
	{
		$fileExt = $fileExt = ImageRepository::getExt($file['type']);

		$s = DIRECTORY_SEPARATOR;

		$to = ROOT . $s . "pic" . $s . $img['path'];

		$full = $to . $s . $img['hash'] . ".{$fileExt}";

		if (!is_dir($to)) {
			mkdir($to);
		}

		if (!is_readable($full)) {
			move_uploaded_file($file['tmp_name'], $full);
		}
	}


}
