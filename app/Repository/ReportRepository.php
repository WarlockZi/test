<?php


namespace app\Repository;

use app\controller\AppController;
use app\core\FS;
use app\model\Product;
use Illuminate\Database\Eloquent\Collection;

class ReportRepository extends AppController
{
    public function noMinimumUnit()
    {
        return Product::whereDoesntHave('shippableUnits')
            ->select('name', 'art', 'id')
            ->withTrashed()
            ->get() ?? Collection::empty();
    }

    public function noDopUnit()
    {
        $p = Product::query()
            ->where('instore', '>', 0)
            ->whereDoesntHave('shippableUnits')
            ->get();
        return $p;
    }

    public function haveDopUnit()
    {
        $p = Product::query()
            ->where('instore', '>', 0)
            ->whereHas('dopUnits')
            ->get();
//            ->toArray();
        return $p;
    }

    public function trashed()
    {
        return Product::query()
            ->with('price')
            ->onlyTrashed()
            ->with('mainImages')
            ->take(20)
            ->orderBy('id', "DESC")
            ->get();
    }

    public function noImgInStore()
    {
        $productsInstoreWithStars = Product::query()
            ->select('art', 'name', '1s_id', 'id', 'instore', 'deleted_at')
            ->where("name", 'REGEXP', "\\*$");

        $products = Product::query()
            ->select('art', 'name', '1s_id', 'id', 'instore', 'deleted_at')
            ->where('instore', '>', 0)
            ->where("name", 'NOT REGEXP', "\\*$")
            ->union($productsInstoreWithStars)
            ->get();
        $a = $products->toArray();

        $arr = new Collection();
        foreach ($products as $product) {
            if (self::hasMainImage($product)) {
                $arr->push($product);
            }
        }
        return $arr;
    }

    private function hasMainImage($product): bool
    {
        $file = ROOT . '/pic/products/uploads/' . "{$product->art}.jpg";
        return file_exists(FS::platformSlashes($file));
    }

    public function noImgNotInStore()
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


}