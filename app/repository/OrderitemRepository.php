<?php


namespace app\repository;


use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\service\AuthService\AuthService;
use Illuminate\Database\Eloquent\Collection;

class OrderitemRepository
{
    public static function updateOrCreate(array $req)
    {
        return OrderItem::updateOrCreate(
            [
                'id' => $req['id'],
            ],
            [
                'id' => $req['id'],
                'count' => $req['count'],
            ]
        );
    }
    public static function main(): Collection|array
    {
        $user = AuthService::getUser();
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