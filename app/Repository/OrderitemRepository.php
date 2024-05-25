<?php


namespace app\Repository;


use app\core\Auth;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;

class OrderitemRepository
{
    public static function leadList()
    {
        $orders = OrderItem::query()
            ->select('product_id', 'id', 'sess', 'count')
            ->has('lead')
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

    public function edit($id)
    {
        try {
            $orderItem = OrderItem::find($id);
            $lead = Lead::where('sess', $orderItem->sess)->first();
            $oItems = OrderItem::query()
                ->where('sesss', $orderItem->sess)
                ->get();

        } catch (\Throwable $exception) {

        }
        return compact('oItems', 'lead');
    }


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

    public static function count()
    {
        $sess = session_id();
        $oItems = OrderItem::where('sess', $sess)->get()->toArray();
        $count = 0;
        if ($oItems) {
            foreach ($oItems as $item) {
                $count += $item['count'];
            }
        }
        return $count;
    }

    public function deleteItem(string $model, string $sess, string $product_id, array $unitIds)
    {
        foreach ($unitIds as $unitId) {
            $oItem = $model::query()
                ->where('sess', $sess)
                ->where('product_id', $product_id)
                ->where('unit_id', $unitId)
                ->first();
            if ($oItem) $oItem::query()->forceDelete();
        }
    }

}