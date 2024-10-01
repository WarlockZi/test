<?php


namespace app\Repository;

use app\model\FilterUser;

class ProductFilterRepository
{
    public static function product(int $userId): array
    {
        $userFilters = FilterUser::where("user_id", $userId)
            ->where('model', 'product')
            ->select('name')
            ->first();
        return $userFilters ? $userFilters->toArray() : [];
    }
}