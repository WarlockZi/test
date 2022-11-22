<?php

namespace app\model\Illuminate;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	protected $fillable = ['name', 'full_name'];
	public $timestamps = false;

	public function products()
	{
		return $this->belongsTo(Product::class,
			'main_unit');
	}

	public static function select(){
		return self::all()
			->pluck('name', 'id')
			->toArray();
	}


}

