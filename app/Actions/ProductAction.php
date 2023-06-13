<?php


namespace app\Actions;


use app\model\Product;
use app\model\Val;

class ProductAction
{

	public static function attach(array $req){
		$product = Product::find($req['morph']['id']);
		$val = Val::with('property')->find($req['morphed']['id']);
		$val->product()->attach($product);
		exit('ok');
	}

	public static function changeVal(array $req){
		if (!$req['old_id']===0){
			MorphAction::attach($req);
		}else if (!$req['new_id'])
			MorphAction::detach($req);
		else{
			MorphAction::attach($req);
		}
		$product = Product::find($req['morph']['id']);
		$val = Val::with('property')->find($req['morphed']['id']);
		$val->product()->attach($product);
		exit('ok');
	}
}