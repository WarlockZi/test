<?php

namespace app\Services\Seo;

use app\model\Product;

class ProductSeoService
{

    public static function title(Product $product): string
    {
        $seoH1 = $product->ownProperties->seo_h1;
        $text = " - купить в Вологде оптом выгодно - VITEX";
        return
            $seoH1
                ? $seoH1 . $text
                : $product->name. $text;
    }
    public static function desc(Product $product): string
    {
        $seoH1 = $product->ownProperties->seo_h1;
        $text = " Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
        return
            $seoH1
                ? $seoH1 . $text
                : $product->name. $text;
    }
}