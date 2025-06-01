<?php


namespace app\repository;

use app\model\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function edit(int $id)
    {
        return Product::query()
            ->withTrashed()
            ->where('id', $id)
            ->whereNotNull('1s_id')
            ->with('category.properties.vals')
            ->with('values')
            ->with('units')
            ->with('ownProperties')
            ->with('category.parentRecursive')
            ->with('manufacturer.country')
//            ->with('mainImages')
//            ->with('detailImages')
//            ->with('smallpackImages')
//            ->with('bigpackImages')
            ->with('promotions')
            ->with('activePromotions')
            ->with('inactivePromotions')
            ->first();
    }

    public function main(string $slug): Product|null
    {
        return Product::query()
            ->withTrashed()
//            ->orderBy('sort')
            ->with('category.properties.vals')
            ->with('ownProperties')
            ->with('category.parentRecursive')
//            ->with('category.parents')
            ->with('values.property')
            ->with('manufacturer.country')
//            ->with('mainImages')
//            ->with('detailImages')
//            ->with('smallpackImages')
//            ->with('bigpackImages')
            ->with('activepromotions.unit')
            ->with('shippableUnits')
            ->with('orders')
            ->with('like')
            ->with('compare')
            ->where('slug', $slug)
            ->first() ?? null;
    }


    public static function similarProducts(string $subslug1, string $subslug2): Collection
    {
        $q = Product::query()
            ->where('slug', 'LIKE', "%{$subslug1}%")
            ->with('activePromotions');
        if ($subslug2) {
            $q->orWhere('slug', 'LIKE', "%{$subslug2}%");
        }
        return $q->get() ?? new \Illuminate\Database\Eloquent\Collection;
    }

    private static function defaultFilter()
    {
        return Product::query()
            ->withTrashed()
            ->take(10)
            ->groupBy('art')
            ->get();
    }


    public function trashed()
    {
        return Product::query()
            ->with('price')
            ->onlyTrashed()
//            ->with('mainImages')
            ->take(20)
            ->orderBy('id', "DESC")
            ->get();
    }

}