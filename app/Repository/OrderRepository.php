<?php


namespace app\Repository;


use app\model\Order;
use app\model\OrderItem;
use app\model\User;


class OrderRepository
{
    public static function deleteItems(string $sess, string $product_id, array $unitIds)
    {
        try {
            foreach ($unitIds as $unitId) {
                $order = Order::query()
                    ->where('sess', $sess)
                    ->where('product_id', $product_id)
                    ->where('unit_id', $unitId)
                    ->first();
                if ($order) $order->delete();
            }
            return true;
        } catch (\Throwable $exception) {
            $exc = $exception;
            return false;
        }
    }


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
        return $orderItems;
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
            ->with('user', 'product', 'product.activePromotions', 'product.inactivePromotions', 'unit')
            ->groupBy('product_id')
            ->get();
        $a      = $orders->toArray();
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