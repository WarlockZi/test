<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;

class OrderitemRepository
{
//    public static function leadList()
//    {
//        $orderItem = OrderItem::query()
//            ->select('product_id', 'id', 'sess', 'count')
//            ->has('lead')
//            ->with('lead')
//            ->with('product')
//            ->groupBy('product_id')
//            ->get();
//        return $orderItem;
//    }

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

//    public function edit($id)
//    {
//        $orderItem = OrderItem::with(['product.activePromotions', 'unit', 'lead'])->find($id);
//        $lead      = Lead::where('sess', $orderItem->sess)->first();
//        $oItems    = OrderItem::query()
//            ->where('sess', $orderItem->sess)
//            ->get();
//        return compact('oItems', 'lead');
//    }


    public static function main()
    {
        $user = Auth::getUser();
        if ($user) {
            $oItems = Order::query()
                ->select('*')
                ->selectRaw('SUM(count) as count_total')
                ->where('user_id', $user['id'])
                ->with('product.price')
                ->groupBy('product_id')
//				->selectRaw('SUM(count) as count_total')
                ->get();
        } else {
            $oItems = OrderItem::query()
                ->where('sess', session_id())
                ->with('product.price')
                ->get();
        }
        return $oItems;
    }


    public function deleteItem(string $sess, string $product_id, string $unitId)
    {
        $oItem = OrderItem::query()
            ->where('sess', $sess)
            ->where('product_id', $product_id)
            ->where('unit_id', $unitId)
            ->first();
        if ($oItem) $oItem::query()->forceDelete();
    }

    public static function deleteItems(string $sess, string $product_id, array $unitIds)
    {
        try {
            foreach ($unitIds as $unitId) {
                $oItem = OrderItem::query()
                    ->where('sess', $sess)
                    ->where('product_id', $product_id)
                    ->where('unit_id', $unitId)
                    ->first();
                if ($oItem) $oItem::query()->forceDelete();
            }
            return true;
        } catch (\Throwable $exception) {
            $exc = $exception;
            return false;
        }

    }
}