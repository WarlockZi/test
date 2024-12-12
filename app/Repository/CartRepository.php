<?php

namespace app\Repository;

use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class CartRepository
{
    public static function count()
    {
        $user   = Auth::getUser();
        if ($user) {
            $order = Order::query()
                ->select('user_id', 'deleted_at')
//                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->with('products.orderItems')
                ->get();
        } else {
            $order = Order::query()
                ->where('sess', session_id())
                ->with('products')
                ->get();
        }
        return $order;
    }

    public static function main(): Order
    {
        $user = Auth::getUser();
        if ($user) {
            $order = Order::query()->where('user_id', Auth::getUser()->id);
        } else {
            $order = Order::query()->where('sess', session_id());
        }
        $order    = $order->whereNull('submitted')
            ->with('products.orderItems.unit')
            ->first();
        $o = $order->toArray();
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

    public static function convertOrderItemsToOrders(array $req, $userId): void
    {
        $oItems = OrderItem::query()
            ->where('sess', $req['sess'])
            ->whereNull('deleted_at')
            ->get();

        foreach ($oItems as $item) {
            $itemArr            = $item->toArray();
            $itemArr['user_id'] = $userId;
            Order::query()->create($itemArr);
            $item->forceDelete();
        }
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