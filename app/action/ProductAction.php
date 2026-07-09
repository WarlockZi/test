<?php

namespace app\action;

use app\model\Order;
use app\model\Product;
use app\repository\OrderRepository;
use app\service\Breadcrumbs\NewBreadArray;
use app\service\Meta\MetaService;


class ProductAction
{
    public function __construct(
        private MetaService       $meta,
        private readonly NewBreadArray $breadcrumbs,
    )
    {
    }

    public function orderProduct(Product $product):?Order
    {
        $order = OrderRepository::usersOrder(currentUser: true);
        if (!$order) return null;

        $orderProduct = $order->products
            ->where('1s_id', $product['1s_id']);
        $order->setRelation('products', $orderProduct);
        return $order;
    }

    public function setMeta(Product $product): array
    {
        return $this->meta->setMeta(
            $product['ownProperties']['seo_title']
            ?? $product['name'] . " - купить в Вологде оптом выгодно - VITEX",

            $product['ownProperties']['seo_description']
            ?? $product['name'] . " Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн",

            $product['ownProperties']['seo_keywords']
            ?? $product['name'],
        );
    }

    public function similarProducts(string $slug): array
    {
        return [];
    }
}