<?php


namespace app\Repository;


use app\core\Cache;
use app\model\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public static function frontCategories()
    {
        return Cache::get('rootCategories',
            function () {
                return Category::withWhereHas('ownProperties',
                    fn($q) => $q->where('show_front', 1))
                    ->with('childrenRecursive')
                    ->get();
            },
            1000
        );
    }

    public function indexInstore(string $url)
    {
        return Cache::get('categoryWithProducts', function () use ($url) {
            $cat = Category::query()
                ->with('childrenRecursive')
                ->withWhereHas('ownProperties',
                    fn($query) => $query->where('path', 'like', $url)
                )
                ->with('products.ownProperties')
//                ->with('products.orders.items')
                ->with('productsInStore.orders.orderItems')
                ->with('productsNotInStoreInMatrix.orders.orderItems')
                ->with(['products.activepromotions' => function ($q) {
                    $q->whereNull('active_till');
                }])
                ->with('products.inactivepromotions')
                ->with('products.shippableUnits')
                ->get()
                ->first();
            return $cat;
        }, 10);
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
//        Cache::delete('categoryTree');
        $cat = Cache::get(
            'categoryTree',
            function () {
                $cats = Category::query()
                    ->where('category_id', null)
                    ->with(['childrenRecursive' => function ($q) {
                            $q->select('id', 'name', 'category_id');
                        }]
                    )
                    ->select('id', 'name')
                    ->whereNull('deleted_at')
                    ->get(['id', 'name']);
                return $cats;
            },
            10
        );
        return $cat;
    }

}