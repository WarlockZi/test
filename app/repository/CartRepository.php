<?php

namespace app\repository;

use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\model\Product;
use app\model\ProductUnit;
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
            ->with('products', function ($q) {
                return $q
                    ->whereHas('orderItems',function($q){
                        return $q->where('count', '>', 0)
                            ->whereHas('productUnit')
                            ->whereNotNull('product_unit_id')
                            ;
                    })
                    ->select('products.id','1s_id', 'name', 'print_name', 'art', 'slug', 'instore', )
                    ->with(['orderItems'=>function($q){
                        return $q
                            ->select('order_product_id', 'product_unit_id', 'count')
                            ->with('productUnit.unit')
                            ;
                    }])
                    ;
            })
            ->whereNull('submitted')
            ->first();

        $o     = $order?->products->each(function (Product $product) {
            $product->append('base_unit');
            $product->append('shippable_units');
        });
        $o = $order?->toArray() ?? [];
        return $o;
    }

    public function updateOrCreate(array $body): void
    {
        $orderId        = OrderRepository::userOrder()->id;
        $orderProductId = OrderProduct::firstOrCreate([
            'order_id' => $orderId,
            'product_id' => $body['product_1s_id'],
        ])->id;
        $productUnitId  = ProductUnit::where([
            'product_1s_id' => $body['product_1s_id'],
            'unit_id' => $body['unit_id'],
        ])
            ->select('id')
            ->first()->id;
        $orderItem      = OrderItem::updateOrCreate([
            'order_product_id' => $orderProductId,
            'product_unit_id' => $productUnitId,
        ],
            [
                'order_product_id' => $orderProductId,
                'product_unit_id' => $productUnitId,
                'count' => $body['count'],
            ]);
    }
}