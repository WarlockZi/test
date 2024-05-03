<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;
use app\model\Product;


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
            ->select('product_id', 'id', 'user_id', 'count')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user')
            ->with('product.price')
            ->groupBy('product_id')
            ->get();
        return $orders;
    }

    public static function main()
    {
        $user = Auth::getUser();
        if ($user) {
            $oItems = Order::query()
                ->select('*')
                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->whereNull('deleted_at')
                ->with('product.price')
                ->with('product.baseUnit')
                ->with('product.dopUnits')
                ->groupBy('product_id')
                ->get();
            $oI     = $oItems->toArray();
        } else {
            $oItems = OrderItem::query()
                ->where('sess', session_id())
                ->with('product.price')
                ->with('product.baseUnit')
                ->with(['baseUnit' => function ($query) {
                    $id = Product::where('1s_id',$query->product['1s_id'])->get()->id;
                    $query->with(
                        ['units' => function ($query) use ($id) {
                            $query->wherePivot('product_id', $id)->get();
                        }]
                    );
                }])
                ->get();
        }
        $arr = $oItems->toArray();
        return $oItems;
    }

    public static function count(): int
    {
        $sess = session_id();
        return OrderItem::where('sess', $sess)->get()->count();
    }
}