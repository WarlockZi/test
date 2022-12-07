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

		foreach ($_FILES as $file) {
			ImageRepository::validateSize((int)$file['size'], file);
			ImageRepository::validateType($file['type'], file);

			$im = ImageRepository::firstOrCreate($file, $morphed);
			if ($im->wasRecentlyCreated) {
				if (ImageRepository::saveToFile($im, $file))
					ImageRepository::sync($im, $morphed, false);
			}
			$this->exitJson([$im->getFullPath()]);
		}

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
		ImageRepository::sync($im, $morphed, false);
		$this->exitJson([$im->getFullPath()]);
	}

}
