<?php


namespace app\Actions;


use app\model\Product;
use app\model\Val;

class UnitAction
{

	public static function changeUnit(array $req){
		$product = Product::find($req['morph']['id']);
		$val = Val::with('property')->find($req['morphed']['id']);
		$val->product()->attach($product);
		exit('ok');
	}
}