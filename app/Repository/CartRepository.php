<?php

namespace app\Repository;

use app\core\Auth;
use app\model\Order;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{

    public static function main(): Order|null
    {
        $user  = Auth::getUser();
        $field = $user ? 'user_id' : 'loc_storage_cart_id';
        $value = $user ? $user->id : $_COOKIE['loc_storage_cart_id'] ?? 'no';

        $q = Order::where($field, $value);

        $order = $q
            ->whereNull('submitted')
            ->with('products.orderItems.unit')
            ->first();

        $a = $order->toArray();
        return $order;
    }

    public static function unsubmittedOrders(): Collection|null
    {
        return Order::query()
            ->where('user_id', Auth::getUser()->id)
            ->whereNotNull('submitted')
            ->with('items.product.units')
            ->get() ?? null;
    }


    public static function edit($id)
    {
        $userId = Order::where('id', $id)->first()->user_id;
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user')
            ->groupBy('product_id')
            ->get();
        return $orders;
    }

}