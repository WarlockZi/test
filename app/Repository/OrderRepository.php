<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;

class OrderRepository
{

	public static function main()
	{
		$sess = session_id();
		$user = Auth::getUser();
		if ($user) {
			$oItems = Order::query()
//			->withTrashed()
				->where('sess', $sess)
				->where('user_id', $user['id'])
				->with('product.price')
				->get();
		} else {
			$oItems = OrderItem::query()
//			->withTrashed()
				->where('sess', $sess)
				->with('product.price')
				->get();
		}


		return $oItems;
	}

	public static function count()
	{
		$sess = session_id();
		$oItems = OrderItem::where('sess', $sess)->get()->toArray();
		$count = 0;
		if ($oItems) {
			foreach ($oItems as $item) {
				$count += $item['count'];
			}
		}
		return $count;
	}
}