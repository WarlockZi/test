<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;


class OrderRepository
{

	public static function list()
	{
		$orders = Order::query()
			->select('product_id', 'id','user_id','count')
			->with('user')
			->with('product')
			->orderBy('user_id')
			->groupBy('user_id')
			->get()
		;
		return $orders;
	}

	public static function edit($id)
	{
		$userId = Order::where('id',$id)->first()->user_id;
		$orders = Order::query()
			->select('product_id', 'id','user_id','count')
			->selectRaw('SUM(count) as total_count')
			->where('user_id',$userId)
			->with('user')
			->with('product.price')
			->groupBy('product_id')
			->get()
		;
		return $orders;
	}
	public static function main()
	{
		$sess = session_id();
		$user = Auth::getUser();
		if ($user) {
			$oItems = Order::query()
				->select('*')
				->selectRaw('SUM(count) as count_total')
				->where('user_id', $user['id'])
				->with('product.price')
				->groupBy('product_id')
//				->selectRaw('SUM(count) as count_total')
				->get();
		} else {
			$oItems = OrderItem::query()
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