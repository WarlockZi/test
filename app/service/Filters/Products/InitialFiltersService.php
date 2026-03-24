<?php

namespace app\service\Filters\Products;

use app\model\Category;
use app\repository\CategoryRepository;
use app\service\Cache\Redis\Cache;

class InitialFiltersService
{
    protected static function categoriesSelector(): array
    {
        $CategoryFlatNestedArray = [0 => ''];
        $rootCats = CategoryRepository::rootCategories();
        $reversed = array_reverse($rootCats);

        foreach ($reversed as $rootCat) {
            $categories      = Category::find($rootCat['id'])
                ->flatSelfAndChildren
                ->map(function ($q) {
                    return $q;
                })
                ->keyBy('s_id')
                ->toArray();

            $i = 0;
            array_combine(
                array_keys($categories),
                array_map(function ($v) use (&$CategoryFlatNestedArray, &$i) {
                    $tab = str_repeat('&nbsp;', $i);
                    $CategoryFlatNestedArray[$v['s_id']] = $tab.$v['name'];
                    ++$i;
                }, $categories)
            );
        }
        return $CategoryFlatNestedArray;
    }

    public static function get(): array
    {
        return Cache::remember('initialFilters', function () {
            return [
                "instore" => [
                    "title" => "наличие",
                    "options" => [
                        0 => '',
                        1 => 'в наличии',
                        2 => 'не в наличии',
                    ],
                ],

                "shippable" => [
                    "title" => "отгруж",
                    "options" => [
                        0 => '',
                        1 => 'без отгруж',
                        2 => 'имеет только ед из 1c',
                        3 => 'без единиц',
                    ],
                ],

                "deleted" => [
                    "title" => "вкл удалленные",
                    "options" => [
                        0 => '',
                        1 => 'все',
                        2 => 'не удаленные',
                        3 => 'удаленные',
                    ],
                ],
                "matrix" => [
                    "title" => "из матрицы",
                    "options" => [
                        0 => '',
                        1 => 'в матрице',
                        2 => 'не в матрице',
                    ],
                ],
                "image" => [
                    "title" => "картинка",
                    "options" => [
                        0 => '',
                        1 => 'с картинкой',
                        2 => 'без картинки',
                    ],
                ],
                "take" => [
                    "title" => "количество строк",
                    "options" => [
                        0 => '',
                        1 => '20',
                        2 => '40',
                        3=>'все'
                    ],
                ],
                "category" => [
                    "title" => "категория",
                    "options" => self::categoriesSelector(),
                ],
            ];

        }, Cache::$timeLife10_000);
    }
}