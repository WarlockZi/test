<?php

namespace app\Services\Seo;

use app\model\Product;

class MainSeoService
{

    public static function title(string $h1): string
    {
        $text = " - интернет-магазин медицинских перчаток и расходников в Вологде - VITEX";
        return $h1 . $text;

    }
    public static function desc(string $h1): string
    {
        $text = ". Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
        return $h1 . $text;
    }
}