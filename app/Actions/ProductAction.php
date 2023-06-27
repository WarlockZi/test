<?php


namespace app\Actions;


use app\model\Product;

class ProductAction
{

	public static function changeVal(array $req)
	{
		$product = Product::find($req['product_id']);
		$newVal = $req['morphed']['new_id'];
		$oldVal = $req['morphed']['old_id'];

		if (!$oldVal) {
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Добавлен']));

		} else if (!$newVal) {
			$product->values()->detach($oldVal);
			exit(json_encode(['popup' => 'Удален']));

		} else {
			if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
			$product->values()->detach($oldVal);
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Поменян']));
		}
	}

	public static function changeUnit(array $req)
	{
		UnitAction::changeUnit($req);
	}

	public static function changePromotion(array $req)
	{
		UnitAction::changeUnit($req);
	}
}