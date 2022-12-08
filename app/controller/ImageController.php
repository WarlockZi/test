<?php

namespace app\controller;

use app\model\Image;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;

class ImageController Extends AppController
{
	public $model = Image::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$list = ImageView::list();
		$this->set(compact('list'));
	}


	public function actionAddMorphMany()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$srcArr = [];

		foreach ($_FILES as $file) {
			ImageRepository::validateSize((int)$file['size'], $file);
			ImageRepository::validateType($file['type'], $file);

			$im = ImageRepository::firstOrCreate($file, $morphed);
			if ($im->wasRecentlyCreated) {
				ImageRepository::saveToFile($im, $file);
			}
			$function = 'detailImages';
			ImageRepository::sync($im, $morphed, $function,true);
			$imageArr['src'] = $im->getFullPath();
			$imageArr['id'] = $im->id;
			$srcArr[] = $imageArr;
		}
		$this->exitJson($srcArr);
	}

	public function actionAddMorphOne()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];

		if (count($_FILES) > 1) $this->exitWithPopup('Можно только один файл');
		$file = $_FILES[0];

		ImageRepository::validateSize((int)$file['size'], $file);
		ImageRepository::validateType($file['type'], $file);

		$im = ImageRepository::firstOrCreate($file, $morphed);
		if ($im->wasRecentlyCreated) {
			ImageRepository::saveToFile($im, $file);
		}
		$function = 'mainImage';
		ImageRepository::sync($im, $morphed, $function,false);
		$this->exitJson([$im->getFullPath()]);
	}

}
