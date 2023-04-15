<?php

namespace app\model;


use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'country_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public static function countrySelect($column, $item)
	{
		return SelectBuilder::build(ArrayOptionsBuilder::build(Country::all())
			->initialOption()
			->selected($item->country->id)
			->get()
		)
			->get();
	}


}