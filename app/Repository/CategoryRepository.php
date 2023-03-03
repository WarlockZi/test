<?php


namespace app\Repository;


use app\model\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

	public static function treeAll():Collection
	{
		return Category::query()
			->where('category_id', 0)
			->with('childrenRecursive')
			->select('id', 'name')
			->get();
	}


}