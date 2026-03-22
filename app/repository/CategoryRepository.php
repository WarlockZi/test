<?php
declare(strict_types=1);

namespace app\repository;


use app\model\Category;
use app\model\CategoryProperty;
use app\model\Product;
use app\service\Breadcrumbs\NewBread;
use app\service\Cache\Redis\Cache;
use Monolog\Logger;

class CategoryRepository
{

//    private function getSameProp($path)
//    {
//        return CategoryProperty::query()
//            ->where('path', $path)->get();
//    }

//    protected function cleanProps()
//    {
//        $props = CategoryProperty::all();
//        $all   = [];
//        foreach ($props as $prop) {
//            $same = $this->getSameProp($prop->path);
//            if ($same->count() > 1) {
//                foreach ($same as $item) {
//                    $all[$prop->path][$item->id] = $item->toArray();
//                    if ($item->seo_article===null) $item->delete();
//                }
//            }
//        }
////        response()->consoleLog($all);
//    }

    public function indexInstore(string $slug): object|null
    {
        $cacheKey = 'categoryWithProducts' . str_replace("/", "", $slug);

        return Cache::remember($cacheKey,
            function () use ($slug) {
                $category = Category::query()
                    ->withWhereHas('ownProperties',
                        fn($query) => $query
                            ->where('path', $slug)
                            ->orWhere('seo_path', $slug)
                    )
                    ->with('meta')
                    ->with(['childrenRecursive' => fn($q) => $q->with('ownProperties')])
                    ->with('parentRecursive')
                    ->with('productsInStore')
                    ->with('productsNotInStoreInMatrix')
                    ->first();

                if ($category) {
//                    $c = $category->toArray();
                    $breadcrumbs           = new NewBread;
                    $category->breadcrumbs = $breadcrumbs->getParents($category);
                    $category->productsInStore->each(function (Product $product) {
                        $product->append('base_unit');
                        $product->append('shippable_units');
                    });
                    $category->productsNotInStoreInMatrix->each(function (Product $product) {
                        $product->append('base_unit');
                        $product->append('shippable_units');
                    });
                    return $category;
                }
                return null;
            },
            Cache::$timeLife1_000);
    }

    public
    static function rootCategories(): array
    {
        return Cache::remember(
            'rootCategories',
            function () {
                return Category::query()
                    ->withWhereHas(
                        'ownProperties',
                        fn($q) => $q->where('show_front', 1))
                    ->with('childrenRecursive')
                    ->with('ownProperties')
                    ->get()
                    ->toArray();
            },
            60);
    }

    public
    static function getBySubslug(string $subslug): object|null
    {
        return Cache::get('similarCategories' . $subslug);
    }


    public
    static function edit(int $id): object
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

    public
    static function treeAll(): array
    {
        return Cache::remember('categoryTree',
            function () {
                return Category::whereNull('category_1s_id')
                    ->with('childrenRecursive')
                    ->get(['id', 's_id', 'category_1s_id', 'name'])
                    ->toArray();
            },
            Cache::$timeLife10_000
        );
    }

}