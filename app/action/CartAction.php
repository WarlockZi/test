<?php

namespace app\action;

use app\model\Order;
use app\model\OrderItem;
use app\repository\OrderRepository;

class CartAction
{

    public function deleteRow(array $body): bool
    {
        $order_id   = $body['order_id'];
        $product_1s_id = $body['product_1s_id'];

        if (!$order_id) response()->json(['msg' => 'No order id']);
        if (!$product_1s_id) response()->json(['msg' => 'No product id']);
        OrderRepository::deleteProduct($order_id,$product_1s_id);

        return true;
    }

}