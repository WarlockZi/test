<?php


namespace app\repository;

use app\model\FilterUser;
use app\model\Product;
use app\service\Image\del\ProductImageService;
use Illuminate\Database\Eloquent\Collection;

class ProductFilterRepository
{
    public static function product(int $userId): array
    {
        $userFilters = FilterUser::where("user_id", $userId)
            ->where('model', 'product')
            ->select('name')
            ->first();
        return $userFilters ? json_decode($userFilters->name, true) : [];
    }

    public function filterProducts($req): Collection
    {
        extract($req);
        $query = Product::query()
            ->with('ownProperties')
//            ->take(10)
        ;

        if (!empty($instore)) {
            if ($instore === '1') {
                $query->where('instore', '>', 0);
            } elseif ($instore === '2') {
                $query->where('instore', '=', 0);
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
            } else if ($take === "3") {
//                $query->take(80);
            }else{
                $query->take(10);
            }
        }else{
            $query->take(10);
        }
        if (!empty($category)) {
            if ($category) {
                $query->where('id', $category);
            }
        }


        if (!empty($image)) {
            if ($image === "1") { /// с картинкой
                $query->whereHas('ownProperties', function ($q)  {
                    $q->where('main_image', '!=', '');
                });

            } else if ($image === "2") { /// без картинки
                $query->whereHas('ownProperties', function ($q)  {
                    $q
                        ->where('main_image', '=', '');
                });
            }
            //        if (!empty($baseIsShippable)) {
//            if ($baseIsShippable === "1") {
//                $query->whereHas('units', function ($q) {
//                    $q->where('is_base', 1)
//                        ->where('is_shippable', 1);
//                });
//            } elseif ($baseIsShippable === "2") {
//                $query->whereHas('units', function ($q) {
//                    $q->where('is_base', 1)
//                        ->where('is_shippable', 0);
//                });
//            } elseif ($baseIsShippable === "3") {
//                $query->withCount('units')
//                    ->having('units_count', '=', 1);
//            }
//        }
        }
        $p   = $query
            ->groupBy('art')
            ->get();
        $arr = $p->toArray();
        return $p;
    }
}