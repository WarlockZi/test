<?php


namespace app\Actions;

use app\model\Order;
use app\model\OrderItem;

class CartAction
{

	public static function convertOrderItemsToOrders(array $req, $userId){

		$oItems = OrderItem::query()
			->where('sess',$req['sess'])
			->whereNull('deleted_at')
			->get();

		foreach ($oItems as $item) {
			$itemArr = $item->toArray();
			$itemArr['user_id'] = $userId;
			Order::query()->create($itemArr);
			$item->forceDelete();
		}
	}

}