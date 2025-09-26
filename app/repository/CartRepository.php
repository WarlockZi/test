<?php

namespace app\repository;

use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\service\AuthService\Auth;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
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

    public static function order(): array
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->with(['products' => function ($q) {
                return $q
                    ->whereHas('orderItems')
                    ->where('order_product.deleted_at', null)
                    ->with(['orderItems' => function ($q) {
                            return
                                $q->withPrice()
                                ->with('unit');
                        }]
                    )
                    ->withBaseUnitPrice()
                    ->withShippableUnitsPrice()
                ;
            }])
            ->first();
        $o     = $order->toArray();
        return $o;
    }

    public function updateOrCreate(array $body): void
    {
        $orderId        = OrderRepository::userOrder()->id;
        $orderProductId = OrderProduct::updateOrCreate([
            'order_id' => $orderId,
            'product_id' => $body['product_1s_id'],
        ])->id;
        $orderItem      = OrderItem::updateOrCreate([
            'order_product_id' => $orderProductId,
            'unit_id' => $body['unit_id'],
            'product_id' => $body['product_1s_id'],
        ],
            [
                'order_product_id' => $orderProductId,
                'count' => $body['count'],
                'product_id' => $body['product_1s_id'],
            ]);
    }
}