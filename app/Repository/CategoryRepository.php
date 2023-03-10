<?php


namespace app\Repository;


use app\model\Category;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

	public static function edit($id)
	{
		return Category::with(
			'products',
			'children',
			'parentRecursive',
			'properties',
			'mainImages')
			->find($id);
	}


	public static function treeAll(): Collection
	{
		return Category::query()
			->where('category_id', 0)
			->with('childrenRecursive')
			->select('id', 'name')
			->get();
	}

	public static function selector(int $selected): string
	{
		return SelectBuilder::build(
			TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
				->initialOption()
				->selected($selected)
				->get()
		)
			->field('category_id')
			->get();
	}


}