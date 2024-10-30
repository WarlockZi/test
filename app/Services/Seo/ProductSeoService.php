<?php

namespace app\Services\Seo;

class ProductSeoService
{

    public static function title(string $title): string
    {
        return $title;
//        $seoH1 = $product->ownProperties->seo_h1;
//        $text = " - купить в Вологде оптом выгодно - VITEX";
    }
    public static function desc(string $description): string
    {
        return $description;
//        $seoH1 = $product->ownProperties->seo_desc;
//        $text = " Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
    }
}