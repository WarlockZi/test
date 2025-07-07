<?php


namespace app\repository;


use app\model\Promotion;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Collection;


class PromotionRepository
{

    public static function product(): Collection|array
    {
        return Promotion::query()
            ->where('active_till', '>', Carbon::today()->toDateString())
            ->with('product.baseUnit')
            ->with('product.price')
            ->get();
    }
    public static function active(): Collection
    {
        return Promotion::query()
            ->where('active_till', '>', Carbon::today()->toDateString())
            ->with('product.baseUnit')
            ->with('product.price')
            ->get();
    }
    public static function inactive(): Collection
    {
        return Promotion::query()
            ->where('active_till', '<', Carbon::today()->toDateString())
            ->with('product.baseUnit')
            ->with('product.price')
            ->get();
    }
}