<?php

$categoryId = $userFilter['category']['id']??null;

$initialFilters = ["instore" => [

    "title" => "наличие",
    "options" => [
        0 => '',
        1 => 'в наличии',
        2 => 'не в наличии',
    ],
],

    "baseIsShippable" => [
        "title" => "баз=отгруж",
        "options" => [
            0 => '',
            1 => 'баз=отгруж',
            2 => 'баз<>отгруж',
        ],
    ],
    "deleted" => [
        "title" => "вкл удалленные",
        "options" => [
            0 => '',
            1 => 'с удаленными',
            2 => 'без удаленных',
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
    "category" => [
        "title" => "категория",
        "options" => \app\Repository\CategoryRepository::reportProductSelector($categoryId),
    ],
];

return $initialFilters;
