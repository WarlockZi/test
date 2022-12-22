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

	public function actionDetach()
	{
		if ($post = $this->ajax) {
			$slug = $post['slug'];
			$morphedClass = '\app\model\\' . ucfirst($post['morphedType']);
			$morphed = $morphedClass::find($post['morphedId']);
			$morphId = $post['morphId'];
			$relation = $morphed->getTable();
			$morphedId = $morphed->id;

			Image::find($morphId)
				->$relation()
				->wherePivot('slug', $slug)
				->detach($morphedId);

				$this->exitWithSuccess('ok');

		}
	}


	public function actionAttachMany()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$morph = $_POST['morph'];
		$srcArr = [];
		$arrImages = [];

		foreach ($_FILES as $file) {
			ImageRepository::validateSize((int)$file['size'], $file);
			ImageRepository::validateType($file['type'], $file);

			$im = ImageRepository::firstOrCreate($file, $morphed, $morph);
			if ($im->wasRecentlyCreated) {
				ImageRepository::saveToFile($im, $file);
			}
			$arrImages[] = $im;
			$arrImages = collect($arrImages);
			$srcArr[] = ImageRepository::sync($arrImages, $morphed, $morph['slug'], false);
		}
		if ($srcArr[0]) {
			$this->exitJson($srcArr);
		}
		$this->exitWithPopup("Уже есть");
	}

	public function actionAttachOne()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$morph = $_POST['morph'];
		$srcArr = [];

		if (count($_FILES) > 1) $this->exitWithPopup('Можно только один файл');
		$file = $_FILES[0];

		ImageRepository::validateSize((int)$file['size'], $file);
		ImageRepository::validateType($file['type'], $file);

		$image = ImageRepository::firstOrCreate($file, $morphed, $morph);
		if ($image->wasRecentlyCreated) {
			ImageRepository::saveToFile($image, $file);
		}

		$res = ImageRepository::sync($image, $morphed, $morph['slug'], false);
		if ($res) {
			$this->exitJson($res);
		}
		$this->exitWithPopup("Уже есть");

	}

}
