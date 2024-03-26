<?php


namespace app\Repository;


use app\model\Promotion;
use Carbon\Carbon;


class PromotionRepository
{

	public static function product()
	{
		return Promotion::query()
			->where('active_till', '>', Carbon::today()->toDateString())
			->with('product.baseUnit')
			->with('product.price')
			->get();
	}

}