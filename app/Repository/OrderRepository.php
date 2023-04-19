<?php


namespace app\Repository;


use app\model\OrderItem;

class OrderRepository
{

	public static function main(){
		$sess = session_id();
		$oItems  = OrderItem::where('sess',$sess)
			->with('product')
			->get()
			;

		return $oItems;
	}

	public static function count(){
		$sess = session_id();
		$oItems  = OrderItem::where('sess',$sess)->get()->toArray();
		$count = 0;
		if ($oItems){
			foreach ($oItems as $item){
				$count+=$item['count'];
			}
		}
		return $count;
	}
}