<?php


namespace app\Repository;


use app\model\Order;
use app\model\OrderItem;
use app\model\User;


class OrderRepository
{
    private static function q2()
    {
        $orderItems = OrderItem::with('product')
            ->groupBy('sess')
            ->get('*');
        return $orderItems;
    }

    public static function leadList()
    {
        $orderItems = self::q2();
//        $orders = OrderItem::query()
//            ->select('id', 'product_id', 'count', 'sess')
//            ->whereHas('lead')
//            ->with('lead')
//            ->with('product')
//            ->groupBy('product_id')
//            ->get();
        return $orderItems;
    }

    private static function q1()
    {
        return
            $orders = Order::query()
                ->select('product_id', 'id', 'user_id',)
                ->with('user', 'product',)
//            ->orderBy('user_id')
                ->groupBy('user_id')
                ->join('orders', 'order.user_id', '=', 'user.id')
                ->get();
    }

    public static function clientList()
    {

        $orders = User::query()
            ->rightJoin('orders', function ($join) {
                $join->on('orders.user_id', '=', 'users.id');
            })
            ->groupBy('users.id')
            ->get();

        return $orders;
    }

    public static function edit($id)
    {
        $userId = Order::where('id', $id)->first()->user_id;
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count', 'unit_id', 'created_at')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user', 'product','product.activePromotions','product.inactivePromotions', 'unit')
            ->groupBy('product_id')
            ->get();
        $a = $orders->toArray();
        return $orders;
    }

    public static function count(): int
    {
        return OrderItem::where('sess', session_id())
            ->whereNull('deleted_at')
            ->get()
            ->count();
    }
}