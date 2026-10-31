<?php


namespace app\repository;


use app\model\Image;
use app\model\Product;
use app\service\Fs\FS;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class ImageRepository
{
    public static $picPath = '/storage/app/pic/';
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


    public static function saveToFile(Model $model, array $file, string $path): bool
    {
        $dir  = FS::ensureDir(0766, $model->imagePath, $path);
        $full = FS::getAbsoluteImagePath($dir, $model);
        if (!is_readable($full)) {
            move_uploaded_file($file['tmp_name'], $full);
            return true;
        }
        return false;
    }







    public static function getImg($path = "")
    {
        $file = ROOT . $path;
        if (is_readable($file) && $path && is_file($file)) {
            return $path;
        } else {
            return ImageView::noImageSrc();
        }
    }


    public static function getFileExt($type)
    {
        $types = self::$types;
        return $types[$type] ?? null;
    }
}
