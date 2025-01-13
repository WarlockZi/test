<?php


namespace app\Repository;


use app\core\Auth;
use app\core\Cache;
use app\model\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public static function rootCategories()
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
        return Cache::get('categoryWithProducts' . str_replace("/", "", $url),
            function () use ($url) {
                $user = Auth::getUser();
                $q    = Category::query()
                    ->with('childrenRecursive')
                    ->withWhereHas('ownProperties',
                        fn($query) => $query->where('path', 'like', $url)
                    )
                    ->with('productsInStore.unsubmittedOrders.orderItems')
                    ->with('productsInStore.ownProperties')
//                    ->orderBy('productsInStore.ownProperties.price')
//                    ->with('productsInStore.like')
                    ->with('productsInStore.inactivepromotions')
                    ->with('productsInStore.orderItems')
                    ->with('productsInStore.shippableUnits')
                    ->with(['productsInStore.activepromotions' => function ($q) {
                        $q->whereNull('active_till');
                    }])
                    ->with('productsNotInStoreInMatrix.unsubmittedOrders.orderItems')
                    ->with('productsNotInStoreInMatrix.ownProperties')
                    ->with('productsNotInStoreInMatrix.orderItems')
                    ->with('productsNotInStoreInMatrix.inactivepromotions')
                    ->with('productsNotInStoreInMatrix.shippableUnits')
                    ->with(['productsNotInStoreInMatrix.activepromotions' => function ($q) {
                        $q->whereNull('active_till');
                    }]);

                $cat = $q->with('productsInStore.compare')
                    ->with('productsInStore.like')
                    ->get()->first();

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

    public static function edit(?int $id): \Illuminate\Database\Eloquent\Model|Collection|\Illuminate\Database\Eloquent\Builder|null
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
            1000
        );
        return $cat;
    }

}