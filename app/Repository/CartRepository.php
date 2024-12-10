<?php

namespace app\Repository;

use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public static function count()
    {
        $oItems = Order::query();
        $user   = Auth::getUser();
        $sess   = session_id();
        if ($user) {
            $oItems
                ->select('user_id', 'deleted_at')
//                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
//                ->where('sess', $sess)
                ->with('product')
                ->get();
        } else {
            $oItems
                ->where('sess', session_id())
                ->with('product')
//                ->groupBy('product_id')
                ->get();
        }
        return $oItems;
    }
    public static function main(): array|null
    {
        $q    = Order::query();
        $user = Auth::getUser();
        if ($user) {
            $q = $q->where('user_id', Auth::getUser()->id);
        } else {
            $q = $q->where('sess', session_id());
        }
        $order = $q->whereNull('submitted')
            ->with(['items' => function ($query) {
                $query->pluck('name', 'item.product_id');
            }])
            ->with('items.product.units')
            ->get()
            ->toArray()
            ?? null;
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