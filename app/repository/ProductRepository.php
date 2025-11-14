<?php


namespace app\repository;

use app\model\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function edit(int $id)
    {
        $product = Product::query()
            ->withTrashed()
            ->with('category.properties.vals')
            ->with('values')
            ->with([
                'units.prices',
            ])
            ->with('ownProperties')
            ->with('category.parentRecursive')
            ->with('manufacturer.country')
            ->with('promotions')
            ->with('activePromotions')
            ->with('inactivePromotions')
            ->find($id);
        if ($product) {
            $product->append('mainImage');
        }
        return $product;
    }

    public function index(string $slug): ?Product
    {
        $prod = Product::query()
            ->withTrashed()
//            ->orderBy('sort')
            ->with('category.properties.vals')
            ->with('values.property')
            ->with('units.prices.type')
            ->with('category.parentRecursive')
            ->with('category.ownProperties')
            ->with('ownProperties')
            ->with('manufacturer.country')
            ->with('activepromotions.unit')
            ->with('order')
            ->with('like')
            ->with('compare')
            ->where('slug', $slug)
            ->first()
        ;

        if ($prod) {
//            $p = $prod->toArray();
            $prod->append('mainImage');
            $prod->append('base_unit');
            $prod->append('shippable_units');
        }

        return $prod;

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