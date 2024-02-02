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
    return Category::with('childrenRecursive')
		->whereNull('category_id')
      ->get();
  }

	public static function getHeaderCategories()
	{
		return Category::query()
			->where('show_front', 1)
			->with('childrenNotDeleted')
			->get();
		return $d;
	}

  public static function editSelectorExcluded($category): array
  {
    $d = Category::query()
      ->where('category_id', $category->id)
      ->select('id')
      ->get()
      ->pluck('id')
      ->push($category->id)
      ->toArray();
    return $d;
  }

  public static function indexInstore(string $slug){
		return Category::query()
			->where('slug', $slug)
			->with('childrenRecursive')
			->with('parentRecursive')
			->with('productsInStore')
//			->with('productsNotInStore')
			->with('productsNotInStoreInMatrix')
			->with('products.promotions')
			->with('seo')
//      ->with('productsNotInStore')
			->get()
			->first();
	}

  public static function edit(?int $id)
  {
    if ($id == null)
      return Category::create();
    return Category::with(
      'products',
      'childrenNotDeleted',
      'childrenDeleted',
      'parentRecursive.properties',
      'properties',
      'mainImages')
      ->find($id);
  }


  public static function treeAll(): Collection
  {
    return Category::query()
      ->where('category_id', null)
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

  public static function selector1(?int $selected, ?array $excluded = []): string
  {
    return SelectBuilder::build(
      TreeOptionsBuilder::build(
          CategoryRepository::treeAll(),
          'children_recursive', 2)
        ->initialOption()
        ->selected($selected)
        ->excluded($excluded)
        ->get()
    )
      ->field('category_id')
      ->get();
  }


}