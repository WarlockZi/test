<?php

namespace app\controller;

use app\core\App;
use app\model\Answer;
use app\model\Image;

class ImageController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	private function checkSize($size)
	{
		if ($size > 1000000) {
			exit(json_encode(['msg' => 'file is too big']));
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
			exit(json_encode(['msg' => 'accepted: png, jpg, jpeg, gif']));
		};
	}

	public function actionCreate()
	{
		// Загрузка картинок drag-n-drop
		if ($_FILES) {
			$file = $_FILES['file'];
			$this->checkSize($file['size']);
			$this->checkType($file['type']);

			$type = $_POST['type'];
			$typeId = $_POST['typeId'];

			$img = [
				'hash' => hash_file('md5', $file['tmp_name']),
				'path' => date('y-m-d'),
				'name' => $file['name'],
				'size' => $file['size'],
				'type' => $file['type'],
			];

			$field = 'hash';
			$val = $img['hash'];

			$found = Image::firstOrCreate($field, $val, $img);
			if (is_array($found)) {
				$id = $found[0]['id'];
			} else {
				$id = Image::autoincrement() - 1;
				$this->move_uploaded_file($file['name'], $img['path'], $file['tmp_name']);
			}
			Image::morphOne($type, $typeId, $id);

			exit(json_encode([
				'msg' => 'ok',
			]));
		}

	}

	public function actionDelete()
	{
		Answer::delete($this->ajax['a_id']);
		exit(json_encode(['msg' => 'ok']));
	}

	public function actionShow()
	{
	}

	protected function move_uploaded_file($fileName, $imgPath, $fileTmpName)
	{
		$f = '\\' . $fileName;
		$to = ROOT . "\\pic\\" . $imgPath;
		if (!is_dir($to)) {
			mkdir($to);
		}
		$to .= $f;
		if (!is_readable($to)) {
			move_uploaded_file($fileTmpName, $to);
		}
	}


}
