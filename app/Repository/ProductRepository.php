<?php


namespace app\Repository;


use app\controller\AppController;
use app\controller\Controller;
use app\controller\FS;
use app\controller\ImageController;
use app\model\Illuminate\Image;
use app\model\Illuminate\Propertable;

class ProductRepository extends Controller
{

	public static function prepareImage($file)
	{
		self::fileValidate($file, 100000,);
		$img = ImageRepository::fromFILES($file);

		$image = Image::firstOrCreate(
			['hash' => $img['hash']],
			$img);

		if ($image->wasRecentlyCreated) {
			ImageController::move_uploaded_file($img, $file);
		}
		return $image;
	}

	protected static function fileValidate($file, int $size = 100)
	{
		if ($file['size'] > $size) exit(json_encode(['popup' => "Файл больше {$size}"]));
		$types = [
			"image/png",
			"image/jpg",
			"image/jpeg",
			"image/gif",
			"image/webp",
		];
		if (!in_array($file['type'], $types))
			exit(json_encode(['popup' => 'Файл должен быть png, jpg, jpeg, gif']));
	}


	public static function clear()
	{
		$deleted = FS::delFilesFromPath('\\pic\\product\\');
		ImageRepository::delAll();
	}
}