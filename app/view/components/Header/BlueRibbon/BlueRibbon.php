<?php


namespace app\view\components\Header\BlueRibbon;


use app\Repository\BlueRibbonRepository;
use app\Repository\CategoryRepository;
use app\Services\FS;

class BlueRibbon
{

    public static function get():string
    {
        $rootCategories = CategoryRepository::rootCategories();
        $fs        = new FS(__DIR__ . '/templates');
        $data      = BlueRibbonRepository::data($rootCategories);
        return $fs->getContent('template', $data);
    }
}