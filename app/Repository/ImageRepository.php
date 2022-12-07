<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Image;
use Illuminate\Database\Eloquent\Model;

class ImageRepository
{
	public static $picPath = '/pic/';
	public static $size = 1000000;
	public static $types = [
		"image/png" => "png",
		"image/jpg" => "jpg",
		"image/jpeg" => "jpeg",
		"image/gif" => "gif",
		"image/webp" => "webp",
	];

	public static $model = Image::class;

	public static function makeModelFromFILES(array $file): array
	{
		return [
			'name' => $file['name'],
			'type' => $file['type'],
			'size' => $file['size'],
		];
	}

	public static function acceptedTypes()
	{
		return [
			'jpg', 'jpeg', 'png', 'webp', 'gif'
		];
	}


	public static function sync(Model $image, array $morphed, bool $withoutDetaching): void
	{
		$modelNameSpace = 'app\\model\\';
		$modelName = $modelNameSpace . ucfirst($morphed['type']);
		$model = $modelName::find($morphed['id']);
		if ($withoutDetaching) {
			$model->mainImage()->syncWithoutDetaching([$image->id => ['slug' => $morphed['slugName']]]);
		} else {
			$model->mainImage()->sync([$image->id => ['slug' => $morphed['slugName']]]);
		}
//			$im->$morphed['type']()->sync([$model->id=>['slug'=>$slugName]]);
	}

	public static function getImagePath(int $id): string
	{
		if ($image = Image::find($id)) {
			return $image->getPath();
		}
		return self::getImg();
	}

	public static function existsInPath(string $path, string $hash, string $ext)
	{
		$file = self::$picPath . $path . DIRECTORY_SEPARATOR . $hash . '.' . $ext;
		return is_readable($file);
	}


	public static function saveToFile(Model $image, $file)
	{
		$dir = FS::getOrCreateAbsolutePath($image->imagePath, $image->path);
		$full = FS::getAbsoluteFilePath($dir, $image);
		if (!is_readable($full)) {
			move_uploaded_file($file['tmp_name'], $full);
			return true;
		}
		return false;
	}

	public static function firstOrCreate(array $file, array $morphed)
	{
		$hash = hash_file('md5', $file['tmp_name']);
		return
			Image::firstOrCreate([
				'hash' => $hash,
				'size' => $file['size'],
				'path' => $morphed['imagePath'],
			], [
				'hash' => $hash,
				'name' => $file['name'],
				'path' => $morphed['imagePath'],
				'type' => ImageRepository::getFileExt($file['type']),
			]);
	}

	public static function validateSize(int $size, array $file)
	{
		$validSize = self::$size;
		if ($size > self::$size) exit(json_encode(['popup' => "Файл {$file} больше {$validSize}"]));
	}

	public static function validateType(string $type,array $file)
	{
		$ext = self::getFileExt($type);
		if (!$ext) exit(json_encode(['popup' => "Файл {$file} должен быть png, jpg, jpeg, gif"]));
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

	public static function imageProductList($file)
	{
		return "<div style='width: 30px;height: 30px;'><img src='$file' style='width: 100%;height: 100%;object-fit: contain'></div>";
	}

	public static function getImgTags(array $image)
	{
		$image = Image::find($image['id']);
		$names = $image->tags
			->pluck('name')
			->map(function ($name) {
				return "<div class='chip'>{$name}</div>";
			})
			->toArray();
		$f = implode('', $names);
		return "<div class='chip-wrap'>{$f}</div>";
	}

	public static function getFileExt($type)
	{
		$types = self::$types;
		return $types[$type] ?? null;
	}


}