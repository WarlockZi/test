<?php


namespace app\Repository;


use app\core\FS;
use app\model\Image;
use app\model\Product;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class ImageRepository
{
	public static $picPath = '/pic/';
	public static $size = 1000000;
	public static $model = Image::class;

	public static $acceptedTypes = [
		'jpg', 'jpeg', 'png', 'webp', 'gif'
	];
	public static $types = [
		"image/png" => "png",
		"image/jpg" => "jpg",
		"image/jpeg" => "jpeg",
		"image/gif" => "gif",
		"image/webp" => "webp",
	];


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

	public static function getProductMainImageSrc(Product $product): string
	{
		$path = "/pic/product/uploads/{$product->art}.jpg";
		echo $path;
		echo "<br>";
		echo $product->art;
		echo "<br>--";
		$pathWithSlashes=FS::platformSlashes(ROOT . $path);
		echo $pathWithSlashes;
		echo "<br>--";
		echo is_readable($pathWithSlashes);
		echo "<br>--";
		echo file_exists($pathWithSlashes);

		if (is_readable(FS::platformSlashes(ROOT . $path))) {
			return $path;
		}
		return ImageView::noImageSrc();
	}

	public static function getProductMainImage(Product $product): string
	{
		$src = ImageRepository::getProductMainImageSrc($product);
		$del = ROOT . FS::platformSlashes($src);
		if (is_readable($del)) {
			$name = $product['name'];
			return "<img src = '{$src}' title = '{$name}' alt = '{$name}'/>";
		} else {
			$src = ImageRepository::getImg('');
			return "<img src = {$src} {$del}/>";
		}
	}

	public static function getSrcMorph(Model $image): array
	{
		$imageArr['src'] = $image->getFullPath();
		$imageArr['id'] = $image->id;
		return $imageArr;
	}

	public static function getMorphOneImage(Model $model, $relation): string
	{
		$items = $model->$relation;
		if ($items->count()) {
			$del = "<div data-detach='' data-id={$items[0]->id}>x</div>";
			$im = "<div class='item'><img src='{$items[0]->getFullPath()}' alt=''>{$del}</div>";
			return "<div class='wrap'>{$im}</div>";
		}
		return '';

	}

	public static function getMorphManyImages(Model $image): string
	{
		$del = "<div data-detach='' class='detach' data-id={$image->id}>x</div>";
		return "<div class='item'><img src='{$image->getFullPath()}' alt=''>{$del}</div>";
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

	public static function saveToFile(Model $model, array $file, string $path): bool
	{
		$dir = FS::getOrCreateAbsolutePath($model->imagePath, $path);
		$full = FS::getAbsoluteImagePath($dir, $model);
		if (!is_readable($full)) {
			move_uploaded_file($file['tmp_name'], $full);
			return true;
		}
		return false;
	}

	public static function firstOrCreate(array $file, string $path)
	{
		$hash = hash_file('md5', $file['tmp_name']);
		return
			Image::firstOrCreate([
				'hash' => $hash,
				'path' => $path,
				'size' => $file['size'],
			], [
				'hash' => $hash,
				'path' => $path,
				'name' => $file['name'],
				'type' => ImageRepository::getFileExt($file['type']),
			]);
	}

	public static function validate(array $file): void
	{
		self::validateSize($file);
		self::validateType($file);
	}

	public static function validateSize(array $file)
	{
		$validSize = self::$size;
		if ($file['size'] > $validSize)
			exit(json_encode(['popup' => "Файл {$file['name']} больше {$validSize}"]));
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
			return ImageView::noImageSrc();
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