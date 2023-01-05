<?php


namespace app\Repository;


use app\controller\FS;
use app\model\Image;
use app\model\Product;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
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
	public static $acceptedTypes = [
		'jpg', 'jpeg', 'png', 'webp', 'gif'
	];
	public static $model = Image::class;


	public static function getSrc(ItemFieldBuilder $field): string
	{
		if ($field) {
			$slug = " data-slug='{$field->slug}'" ?? '';
			$morph = $field->morph;
			$field = $field->item->$morph() ?? 0;
			$src = ImageRepository::getImg($field->getFullPath() ?? '');
			return "<img src='{$src}'{$slug}>";
		}
		return ImageRepository::getImg($field->getFullPath());
	}

	public static function getProductMainImage(Product $product): string
	{
		if ($product->mainImages->count()) {
			$image = $product->mainImages[0];
			$src = ImageRepository::getSrcMorph($image)['src'];
			$name = $product['name'];
			return "<img title = '{$name}'" .
				"src = '{$src}' alt = '{$name}'>";
		} else {
			$src = ImageRepository::getImg();
			return "<img src = {$src}>";
		}
	}

	public static function getSrcMorph(Image $image): array
	{
		$imageArr['src'] = $image->getFullPath();
		$imageArr['id'] = $image->id;
		return $imageArr;
	}

	public static function sync(array $morph, array $morphed, string $slug, string $oneOrMany, bool $detach)
	{
		if ($oneOrMany === 'many') {
			return $res = MorphRepository::attachMany($morph, $morphed, $slug, $detach);
		} else { //one
			$res = MorphRepository::attachOne($morph, $morphed, $slug, $detach);
			if ($res['attached']) {
				return ImageRepository::getSrcMorph($morph[0]);
			}
		}
	}

	public static function getImagePath(int $id): string
	{
		if ($image = Image::find($id)) {
			return $image->getPath();
		}
		return self::getImg();
	}

	public static function existsInPath(string $path, string $hash, string $ext): bool
	{
		$file = self::$picPath . $path . DIRECTORY_SEPARATOR . $hash . '.' . $ext;
		return is_readable($file);
	}


	public static function saveToFile(Model $image, $file)
	{
		$dir = FS::getOrCreateAbsolutePath($image->imagePath, $image->path);
		$full = FS::getAbsoluteImagePath($dir, $image);
		if (!is_readable($full)) {
			move_uploaded_file($file['tmp_name'], $full);
			return true;
		}
		return false;
	}

	public static function firstOrCreate(array $file, array $morph)
	{
		$hash = hash_file('md5', $file['tmp_name']);
		return
			Image::firstOrCreate([
				'hash' => $hash,
				'size' => $file['size'],
				'path' => $morph['path'],
			], [
				'hash' => $hash,
				'name' => $file['name'],
				'path' => $morph['path'],
				'type' => ImageRepository::getFileExt($file['type']),
			]);
	}

	public static function validateSize(array $file)
	{
		$validSize = self::$size;
		if ($file['size'] > $validSize) exit(json_encode(['popup' => "Файл {$file} больше {$validSize}"]));
	}

	public static function validateType(array $file)
	{
		$ext = self::getFileExt($file['type']);
		$types = implode(',', self::$acceptedTypes);
		if (!$ext) exit(json_encode(['popup' => "Файл {$file} должен быть {$types}"]));
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

	public static function getImgByHash(Model $image)
	{
		$picPath = "/pic/{$image['path']}/{$image['hash']}";
		foreach (self::$acceptedTypes as $acceptedType) {
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

	public static function getImgTags(Model $image)
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