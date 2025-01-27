<?php


namespace app\Repository;

use app\core\Response;
use app\model\Product;
use app\model\ProductUnit;
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
//            ->with(['units'=>function ($q) {
//                $q->orderBy('multiplier');
//            }])
            ->with('ownProperties')
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
            ->with('category.parents')
            ->with('mainImages')
            ->with('values.property')
            ->with('manufacturer.country')
            ->with('detailImages')
            ->with('smallpackImages')
            ->with('bigpackImages')
            ->with('activepromotions.unit')
            ->with('shippableUnits')
            ->with('orders')
            ->with('like')
            ->with('compare')
            ->where('slug', $slug)
            ->first() ?? null;
    }

    public function changePromotion(array $req)
    {

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

    public function changeVal(array $req): void
    {
        $product = Product::find($req['product_id']);
        $newVal  = $req['morphed']['new_id'];
        $oldVal  = $req['morphed']['old_id'];

        if (!$oldVal) {
            $product->values()->attach($newVal);
            exit(json_encode(['popup' => 'Добавлен']));

        } else if (!$newVal) {
            $product->values()->detach($oldVal);
            exit(json_encode(['popup' => 'Удален']));

        } else {
            if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
            $product->values()->detach($oldVal);
            $product->values()->attach($newVal);
            exit(json_encode(['popup' => 'Поменян']));
        }
    }

    public function changeUnit(array $req): void
    {
        $productId   = $req['pivot']['product_id'];
        $unitId      = $req['morphed']['new_id'];
        $productUnit = [
            'unit_id' => $unitId,
            'multiplier' => $req['pivot']['multiplier'],
            'is_shippable' => $req['pivot']['is_shippable'],
        ];

        try {
            $unit = ProductUnit::query()
                ->updateOrCreate(
                    ['product_1s_id' => $productId,
                        'unit_id' => $unitId],
                    $productUnit);
            Response::exitWithPopup('изменено');
        } catch (\Throwable $exception) {
            Response::exitWithPopup('не изменено');
        }
    }

    public function deleteUnit(array $req): void
    {
        try {
            $productId = $req['pivot']['product_id'];
            $unitId    = $req['morphed']['old_id'];
            ProductUnit::where('product_1s_id', $productId)
                ->where('unit_id', $unitId)
                ->delete();
            Response::json(['popup' => 'удален', 'ok' => 'ok']);
        } catch (\Throwable $exception) {
            Response::exitWithPopup('не удален');
        }
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

}