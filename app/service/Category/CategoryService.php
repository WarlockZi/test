<?php

namespace app\service\Category;

use app\repository\CategoryRepository;
use app\service\Cache\Redis\Cache;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public static function similarCategories(array $subslugs): array|object|string|null
    {

        $cacheSlug = implode('-', $subslugs);

        $collection = Cache::remember(
            $cacheSlug,
            function () use ($subslugs) {
                $collection = new Collection();
                foreach ($subslugs as $subslug) {
                    $c = CategoryRepository::getBySubslug($subslug);
                    if ($c) $collection = $collection->merge($c);
                }
            },
            Cache::$timeLife10_000
        );

        return $collection;
    }
    public static function setMetad(array $subslugs): array|object|string|null
    {

        $cacheSlug = implode('-', $subslugs);

        $collection = Cache::remember(
            $cacheSlug,
            function () use ($subslugs) {
                $collection = new Collection();
                foreach ($subslugs as $subslug) {
                    $c = CategoryRepository::getBySubslug($subslug);
                    if ($c) $collection = $collection->merge($c);
                }
            },
            Cache::$timeLife10_000
        );

        return $collection;
    }
}