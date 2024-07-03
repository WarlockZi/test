<?php


namespace app\Repository;

use app\model\FilterUser;
use app\model\Product;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Builder;

class ProductFilterRepository
{
    public static function product(int $userId): array
    {
        return FilterUser::where("user_id",$userId)
            ->where('model','product')
            ->select('name')
            ->first()
            ->toArray()
            ??[];
    }

}