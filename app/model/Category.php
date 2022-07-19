<?php

namespace app\model;


use Illuminate\Support\Facades\DB;

class Category extends \Illuminate\Database\Eloquent\Model
{

	public $table = 'categories';
	public $model = 'category';

	protected $fillable = [
		'name' => '',
		'description' => '',
		'category_id' => 0,
		'sort' => 1,
		'img' => '',
	];

	public function oneParent()
	{
		return $this->belongsTo(Category::class);

	}


	public function getParentsAttribute()
	{
		$parents = collect([]);

		$parent = $this->parent();

		while(!is_null($parent)) {
			$parents->push($parent);
			$parent = $parent->parent();
		}

		return $parents;
	}




	public function parent_rec()
	{
		return $this->parent()->with('parent_rec');
	}

	public function parent()
	{
		return $this->belongsTo(Category::class,'category_id');
	}

	public function children()
	{
		return $this->hasMany(Category::class, 'category_id');
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
