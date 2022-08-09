<?php


namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
//
//	public $table = 'properties';
//	public $model = 'property';
	public $timestamps = false;
	protected $fillable = [
		'name' => '',
		'value' => '',
		'description' => '',
	];


	public function categories()
	{
		return $this->morphedByMany(Category::class, 'propertable');
	}

	public function products()
	{
		return $this->morphedByMany(Product::class, 'propertable');
	}
//	public function category(){
//		return $this->belongsTo(Category::class);
//	}

//	public function products(){
//		return $this->morphedByMany(Product::class, 'morph');
//	}
//
//	public function categories(){
//		return $this->morphedByMany(Category::class, 'morph');
//	}

}