<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Order;
use app\model\OrderItem;

class CartRepository
{
    public static function main()
    {
        $user = Auth::getUser();
        $sess = session_id();
        if ($user) {
            $oItems = Order::query()
                ->select('*')
                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->where('sess', $sess)
                ->whereNull('deleted_at')
                ->with('product.units')
                ->groupBy('product_id')
                ->get();
        } else {
            $oItems = OrderItem::query()
                ->where('sess', session_id())
                ->with('product.units')
                ->with('unit')
                ->get()
                ->groupBy('product_id');
//            $oItem = $oItems->toArray();
        }
        return $oItems;
    }

    public static function count()
    {
        $user = Auth::getUser();
        $sess = session_id();
        if ($user) {
            $oItems = Order::query()
                ->select('user_id', 'sess','product_id','deleted_at','count')
                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->where('sess', $sess)
                ->whereNull('deleted_at')
                ->with('product')
                ->groupBy('product_id')
                ->get();
//            $ar = $oItems->toArray();
        } else {
            $oItems = OrderItem::query()
                ->where('sess', session_id())
                ->with('product')
                ->groupBy('product_id')
                ->get();
//            $ar = $oItems->toArray();
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
//    public static function leadList()
//    {
//        $orders = OrderItem::query()
//            ->select('id', 'product_id', 'count', 'sess')
//            ->whereHas('lead')
//            ->with('lead')
//            ->with('product')
//            ->groupBy('product_id')
//            ->get();
//        return $orders;
//    }
//
//    public static function clientList()
//    {
//        $orders = Order::query()
//            ->select('product_id', 'id', 'user_id', 'count')
//            ->with('user')
//            ->with('product')
//            ->orderBy('user_id')
//            ->groupBy('user_id')
//            ->get();
//        return $orders;
//    }


//    public static function count(): int
//    {
//        $sess = session_id();
//        return OrderItem::where('sess', $sess)->get()->count();
//    }
}