<?php


namespace app\Repository;

use app\controller\AppController;
use app\core\FS;
use app\core\Response;
use app\model\Product;
use app\model\ProductUnit;
use app\Services\ProductImageService;
use JetBrains\PhpStorm\NoReturn;

class ProductRepository extends AppController
{
    public function baseUnitPrice(Product $product): string
    {
        $baseUnit = $product->baseUnit->first() ?? 'ед отсутств';
        $price = (float)$product->getRelation('price')->price;
        $formattedPrice = $price
            ? number_format($price, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';

        return "{$formattedPrice} ₽ / {$baseUnit->name}";
    }

//    private function drop()
//    {
//        $pru = ProductUnit::query()
//            ->whereNull('multiplier')
//            ->where('is_base', 1)
//            ->orWhere(function ($q){
//                $q->whereNull('is_shippable')
//                    ->where('is_base', 1);
//            })
//            ->delete();
//        $pru = ProductUnit::query()
//            ->where('is_base', 1)
//            ->where('is_shippable', 1)
//            ->update(['base_is_shippable' => 1]);
//    }

    public function dopUnitsPrices(Product $product): string
    {
//        $this->drop();
        $shippableUnits = $product->shippableUnits;
        if (!$product->shippableUnits->count()) return '';
        $price = $product->price;
        $str = '';
        foreach ($shippableUnits as $unit) {
            $multiplier = $unit->pivot->multiplier ?? 1;
            $formattedPrice = $price && $multiplier
                ? number_format((float)$price * $multiplier, 2, '.', ' ')
                : 'Цену уточняйте у менеджера';
            $str .= "<div class='price-unit-row'>
                <div class='price-for-unit'>
                     {$formattedPrice}
                </div>
                ₽ /
                <div class='unit'>
                {$unit->name}<span> ({$multiplier} {$product->baseUnit->name})</span>
                </div>

            </div>";
        }
        return $str;
    }

    public function edit(int $id)
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
            ->with('orderItems')
            ->where('1s_id', $id)
            ->get();
    }

    public function main(string $slug)
    {
        $slug = "%{$slug}%";
        $p = Product::where('slug', 'Like', $slug)->withTrashed()->first();
        if (!$p) $p = Product::where('short_link', $slug)->first();
        if ($p) {
            $id = $p['1s_id'];
            $product = $this->mainShortSubquery($id)->first();;
            return $product;
        }
        return null;
    }

    public function changePromotion(array $req)
    {

    }

    private static function defaultFilter()
    {
        return Product::query()
            ->withTrashed()
            ->take(10)
            ->groupBy('art')
            ->get()
            ;
    }
    private static function array_every(array $array,callable $callback)
    {
        return  !in_array(false,  array_map($callback,$array));
    }

    public static function filter($req)
    {
        $nullEvry = self::array_every($req, function($f){return $f==0;});
        if ($nullEvry) {
            return self::defaultFilter();
        };
        extract($req);
        $query = Product::query();

        if (isset($instore)) {
            if ($instore === '1') {
                $query->where('instore', '>', 0);
            } elseif ($instore === '2') {
                $query->where('instore', '=', 0);
            }
        }
        if (isset($baseIsShippable)) {
            if ($baseIsShippable === "1") {
                $query->whereHas('units', function ($q) {
                    $q->where('base_is_shippable', 1);
                });
            } elseif ($baseIsShippable === "2") {
                $query->whereHas('units', function ($q) {
                    $q->where('base_is_shippable', 0);
                });
            }
        }

        if (isset($deleted)) {
            if ($deleted == "1") {
                $query->withTrashed();
            }elseif ($deleted === "2") {

            }
        }

        if (isset($matrix)) {
            if ($matrix === '1') {
                $query->where("name", 'REGEXP', "\\*$");
            } elseif ($matrix === '2'){
                $query->where("name", 'NOT REGEXP', "\\*$");
            }
        }

        if (isset($take)) {
            if ($take === "1") {
                $query->take(20);
            } else if ($take === "2") {
                $query->take(40);
            }else{
//                $query->take(10);
            }
        }

        if (isset($category)) {
            if ($category) {
                $query->where('category_id', $category);
            }
        }

        $p = $query
            ->groupBy('art')
            ->get();

        if (isset($image)) {
            $noImg = (new ProductImageService())->getNoPhoto();
            if ($image === "1") {
                $p = $p->filter(function ($product) use ($noImg) {
                    if ($product->mainImage !== $noImg) {
                        return $product;
                    }
                    return false;
                });
            } else if ($image === "2") {
                $p = $p->filter(function ($product) use ($noImg) {
                    if ($product->mainImage === $noImg) {
                        return $product;
                    }
                    return false;
                });
            }
        }
//        $arr = $p->toArray();
        return $p;
    }

    #[NoReturn] public function changeVal(array $req): void
    {
        $product = Product::find($req['product_id']);
        $newVal = $req['morphed']['new_id'];
        $oldVal = $req['morphed']['old_id'];

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
        $productId = $req['pivot']['product_id'];
        $unitId = $req['morphed']['new_id'];
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
            $unitId = $req['morphed']['old_id'];
            ProductUnit::where('product_1s_id', $productId)
                ->where('unit_id', $unitId)
                ->delete();
            Response::exitJson(['popup' => 'удален', 'ok' => 'ok']);
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

    public function list()
    {
        return Product::query()
            ->with('mainImages')
            ->take(20)
            ->orderBy('id', "DESC")
            ->get();
    }

//    public function getFilters()
//    {
//        $self = new static();
//        $filters = [
//            'instore' => 'Показать с остатком = 0',
//            'price' => 'Показать c ценой = 0',
//        ];
//        return FS::getFileContent('./delfilters.php', compact('filters'));
//    }

}