<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'name',
		'show_as',
	];


	public function propertable()
	{
		return $this->morphTo()->with(Val::class);
	}

	public function categories()
	{
		return $this->morphedByMany(Category::class, 'propertable');
	}

	public function products()
	{
		return $this->morphedByMany(Product::class, 'propertable');
	}

	public function vals()
	{
		return $this->hasMany(Val::class);
	}


}