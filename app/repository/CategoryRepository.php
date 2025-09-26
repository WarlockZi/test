<?php
declare(strict_types=1);

namespace app\repository;


use app\model\Category;
use app\service\Breadcrumbs\NewBread;
use app\service\Cache\Redis\Cache;

class CategoryRepository
{

    public function indexInstore(string $url): object|null
    {
        $cacheKey = 'categoryWithProducts' . str_replace("/", "", $url);
        Cache::enabled(false);
        $cacheTime = DEV ? Cache::$timeLife1_000 : 0;

        return Cache::remember($cacheKey,
            function () use ($url) {
                $category = Category::query()
                    ->with('meta')
                    ->with(['childrenRecursive'=>fn($q)=>$q->with('ownProperties')])
                    ->with('parentRecursive')
                    ->withWhereHas('ownProperties',
                        fn($query) => $query->where('path', 'like', $url)
                    )
                    ->with('productsInStore')
                    ->with('productsNotInStoreInMatrix')
                    ->first();
                if ($category) {
                    $breadcrumbs           = new NewBread;
                    $category->breadcrumbs = $breadcrumbs->getParents($category);
                }
                $o = $category->toArray();
                return $category;
            },
            $cacheTime);
    }



    public static function rootCategories(): array
    {
        return Cache::remember(
            'rootCategories',
            function () {
                $tree = Category::tree()
                    ->with('ownProperties')
                    ->get()->toTree()->toArray();
                return $tree;
            },
            60);
    }

    public static function getBySubslug(string $subslug): object|null
    {
        return Cache::get('similarCategories' . $subslug);
    }


    public static function edit(int $id): object
    {
        return Category::with(
            'products',
            'childrenNotDeleted',
            'childrenDeleted',
            'parentRecursive.properties',
            'properties',
            'ownProperties',
        )
            ->findOrNew($id);
    }

    public static function treeAll(): array
    {
        return Cache::remember('categoryTree',
            function () {
                return Category::whereNull('1s_category_id')
                    ->with('childrenRecursive')
                    ->get(['id', '1s_id', '1s_category_id', 'name'])
                    ->toArray();
            },
            Cache::$timeLife10_000
        );
    }

}