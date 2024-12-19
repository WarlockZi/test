<?php


namespace app\Repository;

use app\model\FilterUser;
use app\model\Product;
use app\Services\ProductImageService;

class ProductFilterRepository
{
    public static function product(int $userId): array
    {
        $userFilters = FilterUser::where("user_id", $userId)
            ->where('model', 'product')
            ->select('name')
            ->first();
        return $userFilters ? json_decode($userFilters->name,true) : [];
    }
    private static function array_every(array $array, callable $callback): bool
    {
        return !in_array(false, array_map($callback, $array));
    }
    public static function filterProducts($req)
    {
        extract($req);
        $query = Product::query()->take(10);

        if (!empty($instore)) {
            if ($instore === '1') {
                $query->where('instore', '>', 0);
            } elseif ($instore === '2') {
                $query->where('instore', '=', 0);
            }
        }
        if (!empty($baseIsShippable)) {
            if ($baseIsShippable === "1") {
                $query->whereHas('units', function ($q) {
                    $q->where('base_is_shippable', 1);
                });
            } elseif ($baseIsShippable === "2") {
                $query->whereHas('units', function ($q) {
                    $q->where('base_is_shippable', 0);
                });
            } elseif ($baseIsShippable === "3") {
                $query->withCount('units')
                    ->having('units_count', '=', 1);
            }
        }

        if (!empty($deleted)) {
            if ($deleted == "1") { //все
                $query->withTrashed();
            } elseif ($deleted === "2") { // не удаленные
                $query->whereNull('deleted_at');
            } elseif ($deleted === "3") { //удаленные
                $query->onlyTrashed();
            }
        }

        if (!empty($matrix)) {
            if ($matrix === '1') {
                $query->where("name", 'REGEXP', "\\*$");
            } elseif ($matrix === '2') {
                $query->where("name", 'NOT REGEXP', "\\*$");
            }
        }

        if (!empty($take)) {
            if ($take === "1") {
                $query->take(20);
            } else if ($take === "2") {
                $query->take(40);
            } else {
                $query->take(10);
            }
        }

        if (!empty($category)) {
            if ($category) {
                $query->where('category_id', $category);
            }
        }

        $p = $query
            ->groupBy('art')
            ->get();

        if (!empty($image)) {
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
}