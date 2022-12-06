<?php


namespace app\Repository;


use app\controller\FS;
use app\model\Image;

class ImageRepository
{
  public static $model = Image::class;
  public static $picPath = '/pic/';
  public static $size = 1000000;
  public static $types = [
    "image/png" => "png",
    "image/jpg" => "jpg",
    "image/jpeg" => "jpeg",
    "image/gif" => "gif",
    "image/webp" => "webp",
  ];


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

  public static function getImagePath($illumCategory)
  {
    if ($id = $illumCategory->mainImage) {
      $id = $illumCategory->mainImage[0]['pivot']['image_id'];
      if ($image = Image::find($id)) {
        return $image->getPath();
      }
    }
    return self::getImg();
  }

  public static function existsInPath(string $path, string $hash, string $ext)
  {
    $s = DIRECTORY_SEPARATOR;
    $file = self::$picPath . "{$path}{$s}{$hash}.{$ext}";
    return is_readable($file);
  }

  public static function saveIfNotExist($file, $path = 'product'): bool
  {
    $img = self::makeModelFromFILES($file, $path);

    $image = Image::firstOrCreate(
      ['hash' => $img['hash']],
      $img);

    if ($image->wasRecentlyCreated) {
      self::move_uploaded_file($img, $file);
    }
    return $image;
  }

  protected static function validateSize(int $size)
  {
    $validSize = self::$size;
    if ($size > $validSize) exit(json_encode(['popup' => "Файл больше {$validSize}"]));
  }

  protected static function validateType(string $type)
  {
    if (!self::getExt($type))
      exit(json_encode(['popup' => 'Файл должен быть png, jpg, jpeg, gif']));
  }

  public static function fileValidate($file)
  {
    self::validateSize($file['size']);
    self::validateType($file['type']);
  }

  public static function move_uploaded_file($img, $file)
  {
    $path = FS::getPath('pic', $img['path']);
    if (!is_dir($path)) {
      mkdir($path);
    }
    $fileExt = ImageRepository::getExt($file['type']);
    $full = "{$path}{$img['hash']}.{$fileExt}";
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

  public static function getExt($type)
  {
    $types = self::$types;
    return $types[$type] ?? null;
  }


}