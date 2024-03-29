<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Image;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;

class ImageController Extends AppController
{
	public $model = Image::class;

	public function __construct(array $route)
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$list = ImageView::list(Image::all());
		$this->set(compact('list'));
	}

	public function actionDetach()
	{
		if ($post = $this->ajax) {
			$morphedClass = '\app\model\\' . ucfirst($post['morphedType']);
			$morphed = $morphedClass::find($post['morphedId']);
			$relation = $morphed->getTable();

			Image::find($post['morphId'])
				->$relation()
				->wherePivot('slug', $post['slug'])
				->detach($morphed->id);

			$this->exitWithSuccess('ok');
		}
	}


	public function actionAttachMany()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$morph = $_POST['morph'];
		$images = [];

		foreach ($_FILES as $file) {
			ImageRepository::validate($file);

			$image = ImageRepository::firstOrCreate($file, $morph);
			if ($image->wasRecentlyCreated) {
				ImageRepository::saveToFile($image, $file);
			}
			$images[] = $image;
		}

		$srcs = ImageRepository::sync($images, $morphed, $morph['slug'], 'many',false);
		if ($srcs) {
			$this->exitJson($srcs);
		}
		$this->exitWithPopup("Уже есть");
	}
//
//	public function actionAttachOne()
//	{
//		if (!$_POST) $this->exitWithPopup('нет данных');
//		if (!$_FILES) $this->exitWithPopup('нет файлов');
//		$morphed = $_POST['morphed'];
//		$morph = $_POST['morph'];
//
//		if (count($_FILES) > 1) $this->exitWithPopup('Можно только один файл');
//		$file = $_FILES[0];
//
//		ImageRepository::validateSize($file);
//		ImageRepository::validateType($file);
//
//		$image = ImageRepository::firstOrCreate($file, $morph);
//		if ($image->wasRecentlyCreated) {
//			ImageRepository::saveToFile($image, $file);
//		}
//
//		$res = ImageRepository::sync($image, $morphed, $morph['slug'], 'one', true);
//		if ($res) {
//			$this->exitJson($res);
//		}
//		$this->exitWithPopup("Уже есть такая картинка");
//
//	}
	public function attachOne()
	{
		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$morph = $_POST['morph'];

		if (count($_FILES) > 1) $this->exitWithPopup('Можно только один файл');
		$file = $_FILES[0];

		ImageRepository::validateSize($file);
		ImageRepository::validateType($file);

		$image = ImageRepository::firstOrCreate($file, $morph);
		if ($image->wasRecentlyCreated) {
			ImageRepository::saveToFile($image, $file);
		}

		$res = ImageRepository::sync($image, $morphed, $morph['slug'], 'one', true);
		if ($res) {
			$this->exitJson($res);
		}
		$this->exitWithPopup("Уже есть такая картинка");

	}
}
