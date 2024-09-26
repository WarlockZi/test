<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\model\Image;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;

class ImageController Extends AppController
{
	public string $model = Image::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$list = ImageView::index();
		$this->setVars(compact('list'));
	}

	public function actionDetach(): void
    {
		if ($post = $this->ajax) {
			$morphedClass = '\app\model\\' . ucfirst($post['morphedType']);
			$morphed = $morphedClass::find($post['morphedId']);
			$relation = $morphed->getTable();

			Image::find($post['morphId'])
				->$relation()
				->wherePivot('slug', $post['slug'])
				->detach($morphed->id);

			Response::exitWithSuccess('ok');
		}
	}


	public function actionAttachMany()
	{
		if (!$_POST) Response::exitWithPopup('нет данных');
		if (!$_FILES) Response::exitWithPopup('нет файлов');
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
			Response::exitJson($srcs);
		}
		Response::exitWithPopup("Уже есть");
	}

	public function attachOne()
	{
		if (!$_POST) Response::exitWithPopup('нет данных');
		if (!$_FILES) Response::exitWithPopup('нет файлов');
		$morphed = $_POST['morphed'];
		$morph = $_POST['morph'];

		if (count($_FILES) > 1) Response::exitWithPopup('Можно только один файл');
		$file = $_FILES[0];

		ImageRepository::validateSize($file);
		ImageRepository::validateType($file);

		$image = ImageRepository::firstOrCreate($file, $morph);
		if ($image->wasRecentlyCreated) {
			ImageRepository::saveToFile($image, $file);
		}

		$res = ImageRepository::sync($image, $morphed, $morph['slug'], 'one', true);
		if ($res) {
			Response::exitJson($res);
		}
		Response::exitWithPopup("Уже есть такая картинка");

	}
}
