<?php


namespace app\Repository;


use app\model\Order;
use app\model\OrderItem;


class OrderRepository
{
    public static function leadList()
    {
        $orders = OrderItem::query()
            ->select('id', 'product_id', 'count', 'sess')
            ->whereHas('lead')
            ->with('lead')
            ->with('product')
            ->groupBy('product_id')
            ->get();
        return $orders;
    }

    public static function clientList()
    {
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count')
            ->with('user')
            ->with('product')
            ->orderBy('user_id')
            ->groupBy('user_id')
            ->get();
        return $orders;
    }

    public static function edit($id)
    {
        $userId = Order::where('id', $id)->first()->user_id;
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count', 'unit_id')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user')
            ->with('product')
            ->with('unit')
            ->groupBy('product_id')
            ->get();
        return $orders;
    }

    public static function count(): int
    {
        $sess = session_id();
        return OrderItem::where('sess', $sess)
            ->whereNull('deleted_at')
            ->get()
            ->count()
            ;
    }
}