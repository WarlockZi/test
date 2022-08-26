<?php


namespace app\Repository;


use app\model\Illuminate\Image;

class ImageRepository
{

	public static function fromFILES(array $file): array
	{
		return [
			'name' => $file['name'],
			'type' => $file['type'],
			'size' => $file['size'],
			'hash' => hash_file('md5', $file['tmp_name']),
			'path' => 'product',
		];
	}

	public static function delAll()
	{
		$im = Image::all();
		$im->map(function ($im){
			$im->delete();
		});
	}

	public static function getImg($path = "")
	{
		$file = ROOT . $path;
		if (is_readable($file)&&$path) {
			return $path;
		} else {
			return '/pic/srvc/nophoto-min.jpg';
		}
	}

	public static function getExt($image_type)
	{
		$types = [
			"image/png" => "png",
			"image/gif" => "gif",
			"image/jpg" => "jpg",
			"image/jpeg" => "jpeg",
			"image/webp" => "webp",
		];
		return $types[$image_type];
	}


}