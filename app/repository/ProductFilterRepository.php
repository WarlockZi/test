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

    public function filterProducts(array $req): Collection
    {
        extract($req);
        $query = Product::query()
            ->with('ownProperties')
            ->with('units')
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
            if ($take === "0") {
                $query->take(10);
            } else if ($take === "1") {
                $query->take(20);
            } else if ($take === "2") {
                $query->take(40);
            } else if ($take === "3") {
//                $query->take(40);
            }
        }else{
            $query->take(10);
        }

        if (!empty($category)) {
            if ($category) {
                $query->where('category_1s_id', $category);
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
                        ->whereNull('main_image')
                        ->orWhere('main_image', '=', '')
                    ;
                });
            }
        }

        if (!empty($shippable)) {
            if ($shippable =='1') {//'без отгруж',
                $query->whereDoesntHave('units', function ($q){
                    $q->where('product_unit.is_shippable', 1);
                });
            }elseif ($shippable =='2'){//'имеет только ед из 1c'
                $query->whereDoesntHave('units', function ($q){
                    $q->where('is_from_1s', null);
                });
            }elseif ($shippable =='3'){//без единиц'
                $query->whereDoesntHave('units');
            }
        }

        $p   = $query
            ->groupBy('art')
            ->get();

        $imageFiltered = $p->filter(function ($product){
            $img = $product->ownProperties->main_image;
            $path = ROOT.'/storage/app/pic/product/'.$img;
            return is_readable($path);
        });
        $arr = $imageFiltered->toArray();
        return $imageFiltered;
    }
}