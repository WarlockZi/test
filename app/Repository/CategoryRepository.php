<?php


namespace app\Repository;


use app\model\Category;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\TreeABuilder;
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

	public static function indexNoSlug()
	{
		return Category::where('category_id', 0)
			->with('childrenRecursive')
			->get();
	}

	public static function index(string $slug)
	{
		return Category::where('slug', $slug)
			->with('childrenRecursive')
			->with('parentRecursive')
			->with('products')
			->with('products.mainImages')
			->get()->first();
	}

	public static function edit(?int $id)
	{
		if ($id == null)
			return Category::create();
		return Category::with(
			'products',
			'childrenNotDeleted',
			'childrenDeleted',
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
			->whereNull('deleted_at')
			->get();
	}

	public static function selector(?int $selected, ?int $excluded = -1): string
	{
		return SelectBuilder::build(
			TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
				->initialOption()
				->selected($selected)
				->excluded($excluded)
				->get()
		)
			->field('category_id')
			->get();
	}


}