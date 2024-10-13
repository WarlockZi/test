<?php

namespace app\Repository;

use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;
use app\model\Product;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public static function main(): Collection
    {
        $user = Auth::getUser();
        if ($user) {
            $products = Product::query()
                ->whereHas('orders')
                ->with('orders')
//                ->selectRaw('SUM(count) as count_total')
                ->whereNull('deleted_at')
                ->with('units')
                ->get();

        } else {
            $products = Product::query()
                ->whereHas('orderItems')
                ->with('orderItems')
                ->with('units')
                ->get();
        }
        $oItem = $products->toArray();
        return $products;
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
    public static function count()
    {
        $user = Auth::getUser();
        $sess = session_id();
        if ($user) {
            $oItems = Order::query()
                ->select('user_id', 'sess', 'product_id', 'deleted_at', 'count')
                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->where('sess', $sess)
                ->whereNull('deleted_at')
                ->with('product')
                ->groupBy('product_id')
                ->get();
        } else {
            $oItems = OrderItem::query()
                ->where('sess', session_id())
                ->with('product')
                ->groupBy('product_id')
                ->get();
        }
        return $oItems;
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