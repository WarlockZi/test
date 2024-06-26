<?php


namespace app\Repository;

use app\controller\AppController;
use app\model\Product;
use app\Services\ProductImageService;
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
//        $a = $products->toArray();

        $arr = new Collection();
        foreach ($products as $product) {
            if (!self::hasMainImage($product)) {
                $arr->push($product);
            }
        }
        return $arr;
    }

    public function baseIsShippable(): Collection
    {
        $products = Product::query()
            ->select('art', 'name', '1s_id', 'id', 'instore', 'deleted_at')
            ->with(['units' => function ($q) {
                $q->where('is_base', 1)
                    ->where('is_shippable', 1);
            }])
            ->get();
        return $products;
    }

    private function hasMainImage($product): bool
    {
        $piService = new ProductImageService();
        $src = $piService->getImageRelativePath($product);
        if (!$src) {
            return false;
        }
        return true;
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