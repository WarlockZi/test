<?php


namespace app\Repository;


use app\model\Category;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

    public static function showFrontCategories(): array
    {
        return Category::query()
            ->where('show_front', 1)
            ->with('childrenNotDeleted')
            ->get()->toArray();
    }

    public static function indexNoSlug()
    {
        return Category::where('show_front', 1)
            ->with('childrenRecursive')
            ->get();
    }

//    public static function editSelectorExcluded($category): array
//    {
//        return Category::query()
//            ->where('category_id', $category->id)
//            ->select('id')
//            ->get()
//            ->pluck('id')
//            ->push($category->id)
//            ->toArray();
//    }

    public function indexInstore(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->with('childrenRecursive')
            ->with('ownProperties')
            ->with('parentRecursive')
            ->with('products.ownProperties')
            ->with('products.orderItems')
            ->with('productsInStore')
            ->with('productsNotInStoreInMatrix')
            ->with(['products.activepromotions' => function ($q) {
                $q->whereNull('active_till');
            }])
            ->with('products.inactivepromotions')
            ->with('products.shippableUnits')
            ->get()
            ->first();
//        $c = $category->toArray();
        return $category;

    }

    public static function changeProperty(array $req): void
    {
        $category = Category::find($req['category_id']);
        $newVal   = $req['morphed']['new_id'];
        $oldVal   = $req['morphed']['old_id'];

        if (!$oldVal) {
            $category->properties()->attach($newVal);
            exit(json_encode(['popup' => 'Добавлен']));

        } else if (!$newVal) {
            $category->properties()->detach($oldVal);
            exit(json_encode(['ok' => 'ok', 'popup' => 'Удален']));

        } else {
            if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
            $category->properties()->detach($oldVal);
            $category->properties()->attach($newVal);
            exit(json_encode(['popup' => 'Поменян']));
        }
    }

    public static function edit(?int $id)
    {
        return Category::with(
            'products',
            'childrenNotDeleted',
            'childrenDeleted',
            'parentRecursive.properties',
            'properties',
            'ownProperties',
            'mainImages')
            ->findOrNew($id);
    }

    public static function treeAll(): Collection
    {
        $cat = Category::query()
            ->where('category_id', null)
            ->with('childrenRecursive')
            ->select('id', 'name')
            ->whereNull('deleted_at')
            ->get();
//        $arr = $cat->toArray();
        return $cat;
    }

    public static function selector(?int $selected = 0, ?int $excluded = -1): string
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

//    public static function reportProductSelector(?int $selected = 0, ?int $excluded = -1): string
//    {
//        return SelectBuilder::build(
//            TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
//                ->initialOption()
//                ->selected($selected)
//                ->excluded($excluded)
//                ->get()
//        )
//            ->name('category')
//            ->id('category')
//            ->get();
//    }

}