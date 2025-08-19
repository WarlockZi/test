<?php

namespace app\repository;

use app\model\Order;
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
                $q->whereHas('orderItems');
            }])

            ->first();

        $o         = $order->toArray();
        $shippable = self::setShippableUnits($order);

        $order['products'] = $order['products_with_order_items_and_units'];
        unset($order['products_with_order_items_and_units']);

        return $order;
    }

    private static function setShippableUnits(Order $order): array
    {
        $table = [];
        foreach ($order->productsWithOrderItemsAndUnits as $product) {
            foreach ($product->orderItems as $orderItem) {
                $table['currency']   = '₽';
                $table['multiplier'] = $orderItem->product->unit->pivot->multiplier;
                $table['unit_name']  = $orderItem->product->unit->pivot->full_name;
                $table['unit_price'] = $orderItem->product->price;
            }
        }
        return $table;
    }

    protected function getUnitsTableAttribute(): array
    {
        $arr = [];
        foreach ($this->units as $unit) {
            $id                          = $unit->id;
            $arr[$id]['currency']        = '₽';
            $arr[$id]['product_1s_id']   = $unit->pivot->product_1s_id;
            $arr[$id]['multiplier']      = $unit->pivot->multiplier;
            $arr[$id]['unit_name']       = $unit->name;
            $arr[$id]['base_unit_name']  = $this->baseUnit->name;
            $arr[$id]['unit_price']      = (float)number_format((float)$this->price * $unit->pivot->multiplier, 2, '.', ' ');
            $arr[$id]['base_unit_price'] = (float)number_format((float)$this->price, 2, '.', ' ');
        }
        return $arr;
    }
}