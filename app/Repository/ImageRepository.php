<?php


namespace app\Repository;


use app\controller\ImageController;
use app\model\Illuminate\Image;
use Illuminate\Database\Eloquent\Model;

class ImageRepository
{

	public static function makeModelFromFILES(array $file): array
	{
		return [
			'name' => $file['name'],
			'type' => $file['type'],
			'size' => $file['size'],
			'hash' => hash_file('md5', $file['tmp_name']),
			'path' => 'product',
		];
	}

	public static function acceptedTypes()
	{
		return [
			'jpg', 'jpeg', 'png', 'webp', 'gif'
		];
	}
	public static function saveIfNotExistReturnModel($file):Model
	{
		self::fileValidate($file, 100000,);
		$img = self::makeModelFromFILES($file);

		$image = Image::firstOrCreate(
			['hash' => $img['hash']],
			$img);

		if ($image->wasRecentlyCreated) {
			self::move_uploaded_file($img, $file);
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

		public static function move_uploaded_file($img, $file)
	{
		$fileExt = $fileExt = ImageRepository::getExt($file['type']);
		$s = DIRECTORY_SEPARATOR;
		$to = ROOT . $s . "pic" . $s . $img['path'];
		$full = $to . $s . $img['hash'] . ".{$fileExt}";
		if (!is_dir($to)) {
			mkdir($to);
		}
		if (!is_readable($full)) {
			move_uploaded_file($file['tmp_name'], $full);
		}
	}

	public static function delAll()
	{
		$im = Image::all();
		$im->map(function ($im) {
			$im->delete();
		});
	}

	public static function getImg($path = "")
	{
		$file = ROOT . $path;
		if (is_readable($file) && $path) {
			return $path;
		} else {
			return '/pic/srvc/nophoto-min.jpg';
		}
	}

	public static function getImgByHash(array $image)
	{
		$picPath = "/pic/{$image['path']}/{$image['hash']}";
		foreach (self::acceptedTypes() as $acceptedType) {
			$file = "{$picPath}.{$acceptedType}";
			if (glob(ROOT . $file)) {
				return self::imageProductList($file);
			}
		}
	}

	public static function imageProductList($file){
		return "<div style='width: 30px;height: 30px;'><img src='$file' style='width: 100%;height: 100%;object-fit: contain'></div>";
	}

	public static function getImgTags(array $image)
	{
		$image = Image::find($image['id']);
		$names = $image->tags
			->pluck('name')
			->map(function ($name){
				return "<div class='chip'>{$name}</div>";
			})
			->toArray();
		$f = implode('',$names);
		return "<div class='chip-wrap'>{$f}</div>";
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