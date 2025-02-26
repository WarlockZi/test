<?php


namespace app\Repository;


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

}