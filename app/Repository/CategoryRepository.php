<?php


namespace app\Repository;


use app\model\Category;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
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

    public static function editSelectorExcluded($category): array
    {
        return Category::query()
            ->where('category_id', $category->id)
            ->select('id')
            ->get()
            ->pluck('id')
            ->push($category->id)
            ->toArray();
    }

    public static function indexInstore(string $slug)
    {
        return Category::query()
            ->where('slug', $slug)
            ->with('childrenRecursive')
            ->with('parentRecursive')
            ->with('productsInStore')
            ->with('productsNotInStoreInMatrix')
            ->with('products.activepromotions')
            ->with('products.inactivepromotions')
            ->with('seo')
            ->get()
            ->first();
    }

    public static function edit(?int $id)
    {
        return Category::with(
            'products',
            'childrenNotDeleted',
            'childrenDeleted',
            'parentRecursive.properties',
            'properties',
            'mainImages')
            ->findOrNew($id);
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