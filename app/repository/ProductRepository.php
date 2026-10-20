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
            ->with('category.parentRecursive.ownProperties')
            ->with('category.ownProperties')
            ->with('values')
            ->with('units')
            ->with('ownProperties')
            ->with('manufacturer.country')
//            ->with('promotions')
//            ->withActivePromotions()
            ->with('activePromotions')
//            ->with('inactivePromotions')
            ->find($id);
        if ($product) {
            $product->append('mainImage');
        }
        return $product;
    }

    public function index(string $slug): ?Product
    {
        $prod = Product::query()
            ->where('slug', $slug)
            ->withTrashed()
            ->with('category.properties.vals')
            ->with('category.parentRecursive.ownProperties')
            ->with('category.ownProperties')
            ->with('values.property')
            ->with('ownProperties')
            ->with('manufacturer.country')
            ->withActivePromotions()
            ->first()
            ->append(['mainImage', 'base_unit', 'shippable_units', 'is_liked', 'cart_items', 'is_compared']);
//        $p    = $prod->toArray();

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
    public function updatePrintName(array $validated): string
    {
        try {
            $firstKey = array_key_first($validated['field']);
            $field = $validated['field'][$firstKey];
            $id =   $validated['id'];
            Product::where('id', $id)->update([$firstKey => $field]);
            return 'Поле обновлено';
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

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