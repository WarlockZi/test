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

	private static function checkRequiredArgs(array $args, Controller $context): array
	{
		if (isset($args['morphed_type']))
			$context->exitWithPopup('Нет смежной таблицы');
		if (isset($args['morphed_id']))
			$context->exitWithPopup('Нет id из смежной таблицы');
		if (isset($args['morph_id']))
			$context->exitWithPopup('Нет id картинки');
		return [$args['morphed'], $args['morph'], $args['morphed']['slugName']];
	}

	public function actionAddMorph()
	{
		$modelNameSpace = 'app\\model\\';

		if (!$_POST) $this->exitWithPopup('нет данных');
		if (!$_FILES) $this->exitWithPopup('нет файлов');

		[$morphed, $morph, $slugName] = self::checkRequiredArgs($_POST, $this);
		foreach ($_FILES as $file) {
			ImageRepository::validateSize($file['size']);
			ImageRepository::validateType($file['type']);

			$hash = hash_file('md5', $file['tmp_name']);

			$im = Image::firstOrCreate([
				'hash'=>$hash,
				'size'=>$file['size'],
				'path'=>$morphed['imagePath'],
			],[
				'hash'=>$hash,
				'name'=>$file['name'],
				'path'=>$morphed['imagePath'],
				'type'=>ImageRepository::getExt($file['type']),
			]);

			if ($im->wasRecentlyCreated) {
				ImageRepository::saveToFile($im->toArray());
			}
			$modelName = $modelNameSpace . ucfirst($morphed['type']);
			$model = $modelName::find((int)$morphed['id']);

			$model->mainImage()->sync([$im->id=>['slug'=>$slugName]]);
//			$im->$morphed['type']()->sync([$model->id=>['slug'=>$slugName]]);
			$src = ImageRepository::getImagePath($im->id);
			$this->exitJson([$src]);
		}
	}

	private
	function checkSize($size)
	{
		if ($size > 1000000) {
			$this->exitWithPopup('Файл слишком большой');
		}
	}

	private
	function checkType($type)
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
}
