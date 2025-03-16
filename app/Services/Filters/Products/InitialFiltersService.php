<?php

namespace app\Services\Filters\Products;

use app\core\Cache;
use app\model\Category;
use app\Repository\CategoryRepository;

class InitialFiltersService
{
    protected static function categoriesSelector(): array
    {
        $CategoryFlatNestedArray = [0 => ''];

        foreach (CategoryRepository::rootCategories()->reverse() as $rootCat) {
            $categories      = Category::find($rootCat->id)
                ->flatSelfAndChildren
                ->map(function ($q) {
                    return $q;
                })
                ->keyBy('id')
                ->toArray();

            $i = 0;
            array_combine(
                array_keys($categories),
                array_map(function ($v) use (&$CategoryFlatNestedArray, &$i) {
                    $tab = str_repeat('&nbsp;', $i);
                    $CategoryFlatNestedArray[$v['id']] = $tab.$v['name'];
                    ++$i;
                }, $categories)
            );
        }
        return $CategoryFlatNestedArray;
    }

    public static function get(): array
    {
        return Cache::get('initialFilters', function () {
            return [
                "instore" => [
                    "title" => "наличие",
                    "options" => [
                        0 => '',
                        1 => 'в наличии',
                        2 => 'не в наличии',
                    ],
                ],

                "baseIsShippable" => [
                    "title" => "баз = отгруж",
                    "options" => [
                        0 => '',
                        1 => 'баз=отгруж',
                        2 => 'баз<>отгруж',
                        3 => 'имеет только баз',
                        4 => 'без единиц',
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
                    "title" => "получить количество",
                    "options" => [
                        0 => '',
                        1 => '20',
                        2 => '40',
                    ],
                ],
//    "categoryHasCustomSeoPath" => [
//        "title" => "категория перенаправлена",
//        "options" => [
//            0 => '',
//            1 => '1',
//            2 => '0',
//        ],
//    ],
                "category" => [
                    "title" => "категория",
                    "options" => self::categoriesSelector(),
                ],
            ];

        }, Cache::$timeLife10_000);
    }
}