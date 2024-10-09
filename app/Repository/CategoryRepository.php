<?php


namespace app\Repository;


use app\model\Category;
use app\model\CategoryProperty;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

    public static function showFrontCategories(): array
    {
        $rootCats = CategoryProperty::query()
            ->where('show_front', 1)
//            ->with('childrenNotDeleted')
            ->with('category.childrenRecursive')
            ->get()
            ->toArray();
        return $rootCats;
    }

    public static function indexNoSlug()
    {
        return Category::where('show_front', 1)
            ->with('childrenRecursive')
            ->get();
    }

    public static function frontCategories()
    {
        $cat = Category::withWhereHas('ownProperties',
            fn($q) => $q->where('show_front', 1))
            ->get();

        return $cat;
    }

    public function indexInstore(string $path)
    {
        $category = Category::query()
            ->with('childrenRecursive')
            ->withWhereHas('ownProperties',
                fn($query) => $query->where('path', 'like', $path)
            )
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
            ->with('childrenRecursive',)
            ->with('ownProperties')
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