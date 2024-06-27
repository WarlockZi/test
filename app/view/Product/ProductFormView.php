<?php


namespace app\view\Product;


use app\model\Product;
use app\view\components\Builders\Builder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Collection;


class ProductFormView
{
//    protected static function getImage(Product $product, string $relation, string $slug, bool $many = false)
//    {
//        $imgs = ImageView::morphImages($product, $relation);
//
//        $img = MorphBuilder::build($product, $relation, $slug, $many)
//            ->detach('detach')
//            ->html(DndBuilder::make('product') . $imgs)
//            ->get();
//
//        return $img;
//    }
//
//
//    protected static function getDescription($product): string
//    {
//        return include ROOT . '/app/view/Product/description.php';
//    }
//
//    protected static function clean(string $str)
//    {
//        $builder = new Builder();
//        return $builder->clean($str);
//    }
//
//    public static function getCardDetailImage($image)
//    {
//        $im = "<img class = 'detail-image' src='{$image->getFullPath($image)}' alt=''></img>";
//        return "<div class='detail-image-wrap'>{$im}</div>";
//    }
//
    public static function getCardImages(string $title, Collection $collection, string $class = 'detail-images-wrap')
    {
        ob_start();
        $detail_image = '';
        foreach ($collection as $image) {
            $detail_image .= self::getCardDetailImage($image);
        }
        include ROOT . '/app/view/Product/card/detail_images.php';
        return ob_get_clean();
    }
}