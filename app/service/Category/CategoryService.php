<?php

namespace app\service\Category;

use app\repository\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public static function similarCategories(array $subslugs): Collection
    {
        $collection = new Collection();
        foreach ($subslugs as $subslug) {
            $c = CategoryRepository::getBySubslug($subslug);
            $collection = $collection->merge($c);
        }
        return $collection;
    }
}