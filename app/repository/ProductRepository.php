<?php


namespace app\repository;

use app\model\Product;
use app\service\Utils\UtilsServise;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function edit(int $id)
    {
//        UtilsServise::cleanUnitsFromIs();
        return Product::query()
            ->withTrashed()
            ->where('id', $id)
//            ->whereNotNull('1s_id')
//            ->with('category.properties.vals')
//            ->with('values')
            ->with([
                'units.prices.type',

//                'prices',
//                'units.prices',
                'unitFrom1s'
            ])
//            ->with('shippableUnits')
//            ->with('unitFrom1s.price1s.type')

//            ->with('ownProperties')
//            ->with('category.parentRecursive')
//            ->with('manufacturer.country')
//            ->with('promotions')
//            ->with('activePromotions')
//            ->with('inactivePromotions')
            ->first();
    }

    public function index(string $slug): ?Product
    {
        return Product::query()
            ->withTrashed()
//            ->orderBy('sort')
            ->with('category.properties.vals')
            ->with('values.property')
            ->with('baseUnit.price1s')
            ->with('shippableUnits.price1s')
            ->with('category.parentRecursive')
            ->with('category.ownProperties')
            ->with('ownProperties')
            ->with('manufacturer.country')
            ->with('activepromotions.unit')
            ->with('orders')
            ->with('like')
            ->with('compare')
            ->where('slug', $slug)
            ->first();
    }


    public static function similarProducts(string $subslug1, string $subslug2): Collection
    {
        $q = Product::query()
            ->where('slug', 'LIKE', "%{$subslug1}%")
            ->with('activePromotions');
        if ($subslug2) {
            $q->orWhere('slug', 'LIKE', "%{$subslug2}%");
        }
        return $q->get();
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