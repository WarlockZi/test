<?php
declare(strict_types=1);

namespace app\repository;


use app\model\Category;
use app\service\Cache\Redis\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository
{
    public static function rootCategories()
    {
        return Cache::remember('rootCategories', function () {

            $cat = Category::withWhereHas('ownProperties',
                fn($q) => $q->where('show_front', 1))
                ->with('childrenRecursive')
                ->get()->toArray();
            return $cat;
        }, 60);
    }

    public static function getBySubslug(string $subslug)
    {
        return Cache::get('similarCategories' . $subslug,
            function () use ($subslug) {
                return Category::where('slug', 'LIKE', "%{$subslug}%")
                    ->get();
            },
            Cache::$timeLife1_000
        );
    }

    public function indexInstore(string $url):object
    {
        $cacheKey = 'categoryWithProducts' . str_replace("/", "", $url);

        return Cache::remember($cacheKey,
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
                return $category;
            }, Cache::$timeLife1_000);
    }


    public static function edit(int $id): Model|Collection|Builder|null
    {
        return Category::with(
            'products',
            'childrenNotDeleted',
            'childrenDeleted',
            'parentRecursive.properties',
            'properties',
            'ownProperties',
//            'mainImages'
        )
            ->findOrNew($id);
    }

    public static function treeAll(): array
    {
        $cat = Cache::remember('categoryTree',
            function () {
                $cats = Category::whereNull('1s_category_id')
                    ->with('childrenRecursive')
                    ->get(['id', '1s_id', '1s_category_id', 'name']);
                return $cats;
            },
            Cache::$timeLife1_000
        );
        return $cat->toArray();
    }

}