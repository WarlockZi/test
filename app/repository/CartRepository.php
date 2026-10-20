<?php

namespace app\repository;

use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\model\ProductUnit;
use app\service\AuthService\AuthService;
use app\strategy\CartStrategy\AccountCartStrategy;
use app\strategy\CartStrategy\GuestCartStrategy;
use app\strategy\CartStrategy\ICartStrategy;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    private ICartStrategy $strategy;
    public function __construct()
    {
        $this->strategy = AuthService::accountId()
            ?new AccountCartStrategy()
            :new GuestCartStrategy();
    }

    public function getItems()
    {
        return $this->strategy->getItems();
    }

    public static function edit($id): Collection|array
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

    public static function incrementGuestToAccountCart($account_id, $product_id, $unit_id, $count): void
    {
        $affected = OrderItem::where([
            'product_1s_id' => $product_id,
            'unit_id' => $unit_id,
            'account_id' => $account_id,
        ])->increment('count', $count);

        if ($affected === 0) {
            $orderItem = OrderItem::create([
                'product_1s_id' => $product_id,
                'unit_id' => $unit_id,
                'count' => $count,
                'account_id' => $account_id,
            ]);
        }
    }
//    public function updateOrCreate(array $body): void
//    {
//        $orderId        = OrderRepository::usersOrder(onlyField: 'id');
//        $orderProductId = OrderProduct::firstOrCreate([
//            'order_id' => $orderId,
//            'product_id' => $body['product_1s_id'],
//        ])->id;
//        $productUnitId  = ProductUnit::where([
//            'product_1s_id' => $body['product_1s_id'],
//            'unit_id' => $body['unit_id'],
//        ])
//            ->select('id')
//            ->first()->id;
//        $orderItem      = OrderItem::updateOrCreate([
//            'order_product_id' => $orderProductId,
//            'product_unit_id' => $productUnitId,
//        ],
//            [
//                'order_product_id' => $orderProductId,
//                'product_unit_id' => $productUnitId,
//                'count' => $body['count'],
//            ]);
//    }
}