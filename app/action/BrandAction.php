<?php

namespace app\action;


use app\service\Meta\MetaService;

class BrandAction
{
    public function __construct(
        private MetaService     $meta,
        private readonly string $titleTail = " купить в интернет-магазине VITEX в Вологде. Большой ассортимент медицинской одежды, оборудования и расходников по выгодной цене. Звоните и заказывайте прямо сейчас онлайн на сайте",
    )
    {
    }

    public function setMeta(string $brand): MetaService
    {
        $title       = $brand . ' - Витекс';
        $description = $brand . ' ' . $this->titleTail;
        $keywords    = $brand;
        return $this->meta->setMeta($title, $description, $keywords,);
    }

}