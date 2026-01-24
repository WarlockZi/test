<?php

namespace app\service\Seo;

use app\model\Category;

class CategorySeoService
{

    public static function title(string $title): string
    {
        return $title;
//        $text  = " - купить оптом недорого в интернет-магазине VITEX в Вологде";
    }

    public static function desc(string $description): string
    {
        return $description;
//        $text    = ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
    }
}