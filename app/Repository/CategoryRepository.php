<?php


namespace app\Repository;


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
            Cache::$timeLife1_000
        );
    }

    public function indexInstore(string $url)
    {
        return Cache::get('categoryWithProducts' . str_replace("/", "", $url),
            function () use ($url) {
                $category = Category::query()
                    ->with('childrenRecursive')
                    ->with('parentRecursive')
                    ->withWhereHas('ownProperties',
                        fn($query) => $query->where('path', 'like', $url)
                    )
                    ->with('productsInStore')
                    ->with('productsNotInStoreInMatrix')
                    ->get()->first();
                $c        = $category->toArray();

                return $category;
            }, Cache::$timeLife1_000);
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
        $cat = Cache::get(
            'categoryTree',
            function () {
                $cats = Category::query()
                    ->where('1s_category_id', null)
                    ->with(['childrenRecursive' => function ($q) {
                            $q->select('id', 'name', '1s_category_id');
                        }]
                    )
                    ->select('1s_category_id', 'id', 'name')
                    ->whereNull('deleted_at')
                    ->get(['id', '1s_category_id', 'name']);
                return $cats;
            },
            Cache::$timeLife1_000
        );
        return $cat;
    }

}