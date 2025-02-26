<?php

namespace app\Repository;

use app\model\OrderProduct;

class OrderProductRepository
{

    public static function firstOrCreate($orderId, $productId)
    {
        return OrderProduct::firstOrCreate(
            ['order_id' => $orderId,
                'product_id' => $productId],
            ['order_id' => $orderId,
                'product_id' => $productId]);
    }

}