<?php

namespace app\Services\Seo;

use app\model\Category;

class CategorySeoService
{

    public static function title(string $title): string
    {
        return $title;
//        $seoH1 = $category->ownProperties->seo_h1;
//        $text  = " - купить оптом недорого в интернет-магазине VITEX в Вологде";
//        return $seoH1
//            ? $seoH1 . $text
//            : $category->name . $text;
    }

    public static function desc(string $description): string
    {
        return $description;
//        $seoH1 = $category->ownProperties->seo_h1;
//        $text    = ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
//
//        return $seoH1
//            ? $seoH1 . $text
//            : $category->name . $text;
    }
}