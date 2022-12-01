<?php

namespace app\controller;

use app\model\Image;
use app\view\Image\ImageView;

class ImageController Extends AppController
{
	public $model = Image::class;

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

	public function actionIndex()
	{
		$list = ImageView::list();
		$this->set(compact('list'));
	}

	private static function checkRequiredArgs(array $args, Controller $context):void{

			if (isset($args['morphed_type']))
				$context->exitWithPopup('Нет смежной таблицы');
			if (isset($args['morphed_id']))
				$context->exitWithPopup('Нет id из смежной таблицы');
			if (isset($args['morph_id']))
				$context->exitWithPopup('Нет id картинки');
	}

	public function actionAddMorph(){
		if ($this->ajax){
			self::checkRequiredArgs($this->ajax, $this);
			$im = Image::find($this->ajax['morph_id']);
			$morphed = $this->ajax['morphed_type'];
			$morphed_id = $this->ajax['morphed_id'];
			$model = $morphed::find($morphed_id);
			$im->sync($model);
		}
	}

//	public static function move_uploaded_file($img, $file)
//	{
//		$fileExt = $fileExt = ImageRepository::getExt($file['type']);
//		$s = DIRECTORY_SEPARATOR;
//		$to = ROOT . $s . "pic" . $s . $img['path'];
//		$full = $to . $s . $img['hash'] . ".{$fileExt}";
//		if (!is_dir($to)) {
//			mkdir($to);
//		}
//		if (!is_readable($full)) {
//			move_uploaded_file($file['tmp_name'], $full);
//		}
//	}
}
