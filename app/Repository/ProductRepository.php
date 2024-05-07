<?php


namespace app\Repository;

use app\controller\AppController;
use app\core\FS;
use app\model\Product;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends AppController
{
    public static function edit(int $id)
    {
        $id = Product::where('id', $id)->withTrashed()->first()['1s_id'];
        return Product::query()
            ->withTrashed()
            ->where('1s_id', $id)
            ->with('category.properties.vals')
            ->with('values')
            ->with('category.parentRecursive')
            ->with('category.parents')
            ->with('mainImages')
            ->with('manufacturer.country')
            ->with('detailImages')
            ->with('promotions')
            ->with('activePromotions')
            ->with('inactivePromotions')
            ->with('smallpackImages')
            ->with('bigpackImages')
            ->with('seo')
            ->with('dopUnits')
            ->first();
    }

    protected function mainShortSubquery($id)
    {
        return Product::query()
            ->withTrashed()
            ->orderBy('sort')
            ->with('category.properties.vals')
            ->with('category.parentRecursive')
            ->with('category.parents')
            ->with('mainImages')
            ->with('values.property')
            ->with('manufacturer.country')
            ->with('detailImages')
            ->with('smallpackImages')
            ->with('bigpackImages')
            ->with('activepromotions.unit')
            ->with('seo')
            ->with('shippableUnits')
//            ->with('dopUnits')
//            ->with(['units' => function ($query) use ($id) {
//                $query->wherePivot('main', 1)
//                    ->first();
//            }])
            ->where('1s_id', $id)
            ->get();
    }

    public static function main(string $slug)
    {
        $repo = new ProductRepository();
        $p    = Product::where('slug', $slug)->withTrashed()->first();
        if (!$p) $p = Product::where('short_link', $slug)->first();
        if ($p) {
            $id      = $p['1s_id'];
            $product = $repo->mainShortSubquery($id)->first();;
            return $product;
        }
        return '--- Product repo error ---';
    }

    public static function short(string $short)
    {
        $self = new self();
        $p    = Product::where('short_link', $short)->firstOrFail();
//        if ()
        $id      = $p['1s_id'];
        $product =
            $self->mainShortSubquery($id)
                ->first();;

        $p = $product->toArray();
        return $product;
    }

    public static function noMinimumUnit()
    {
        return  Product::whereDoesntHave('dopUnits')
            ->select('name', 'art', 'id')
            ->withTrashed()
            ->get();
    }

    public static function noDopUnit()
    {
        $p = Product::query()
            ->where('instore', '>', 0)
            ->whereDoesntHave('dopUnits')
            ->get();
        return $p;
    }

    public static function haveDopUnit()
    {
        $p = Product::query()
            ->where('instore', '>', 0)
            ->whereHas('dopUnits')
            ->get();
//            ->toArray();
        return $p;
    }

    protected static function getP($products)
    {
        foreach ($products as $k => $product)
            return $product;
    }

    public static function trashed()
    {
        return Product::query()
            ->with('price')
            ->onlyTrashed()
            ->with('mainImages')
            ->take(20)
            ->orderBy('id', "DESC")
            ->get();
    }

    public static function list()
    {
        return Product::query()
            ->with('price')
            ->with('mainImages')
            ->take(20)
            ->orderBy('id', "DESC")
            ->get();
    }

    public static function hasMainImage(Product $p)
    {
        return $p->mainImagePath == '/pic/srvc/nophoto-min.jpg';
    }

    public static function noImgInStore()
    {
        $productsInstoreWithStars = Product::query()
            ->select('art', 'name', 'id', 'instore')
            ->where("name", 'REGEXP', "\\*$");

        $products = Product::query()
            ->select('art', 'name', 'id', 'instore')
            ->where('instore', '>', 0)
            ->where("name", 'NOT REGEXP', "\\*$")
            ->union($productsInstoreWithStars)
            ->get();
        $a        = $products->toArray();

        $arr = new Collection();
        foreach ($products as $product) {
            if (self::hasMainImage($product)) {
                $arr->push($product);
            }
        }
        return $arr;
    }

    public static function noImgNotInStore()
    {
        $products = Product::query()
            ->select('art', 'name', 'id', 'instore')
            ->where('instore', '<', 0)
            ->get();

        $arr = new Collection();
        foreach ($products as $product) {
            if (self::hasMainImage($product)) {
                $arr->push($product);
            }
        }
        return $arr;
    }

    public static function clear()
    {
        $deleted = FS::delFilesFromPath("\pic\product\\");
        ImageRepository::delAll();
    }

    public static function priceStatic($column, $item, $d)
    {
        return $item->getRelation('price')->price ?? 0;
    }

    public static function imageStatic($column, $item, $d)
    {
        $art = trim($item->art);
        $src = "/pic/product/uploads/{$art}.jpg";
        if (is_file(ROOT . $src)) {
            return "<img style='width: 50px; height: 50px;' src='{$src}'>";
        } else {
            return ImageView::noImage();
        }
    }

    public static function getFilters()
    {
        $self    = new static();
        $filters = [
            'instore' => 'Показать с остатком = 0',
            'price' => 'Показать c ценой = 0',
        ];
        return FS::getFileContent('./filters.php', compact('filters'));
    }
}