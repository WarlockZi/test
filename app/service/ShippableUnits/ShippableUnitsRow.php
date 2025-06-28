<?php

namespace app\service\ShippableUnits;

use app\repository\OrderRepository;

class ShippableUnitsRow
{

    public static function row($product, $unit, $orderItem): array
    {

        $order = OrderRepository::usersOrder();
        $count      = 0;
        if ($order) {
            if ($order->products->contains($product)) {
                $product = $order->products->find($product);
                $orderItem = $product->orderItems->filter(
                    function ($orderItem) use ($unit) {
                        return $orderItem->unit_id === $unit->id;
                    });
                $count = $orderItem->first()->count??0;
            }
        }
//        $order      = $product?->order;
//        $count      = $order ? self::getCount($unit, $product) : 0;
        $price = (float)$product->price;
        $multiplier = $unit->pivot->multiplier ?? 1;
        $unit_price = $multiplier * $price;
        $rowSum     = round($unit_price * $count);

        return [
            "unit_name" => $unit->name,
            "unit_id" => $unit->id,
            "base_unit_name" => $product->baseUnit->name,
            "unit_price" => $unit_price,
            "formatted_unit_price" => self::format($unit_price),
            "order_item_id" =>  0,
//            "order_item_id" => $orderItem->id ?? 0,
            "count" => 0,
//            "count" => $orderItem->count ?? 0,
            "multiplier" => number_format($multiplier, 0, '', ' '),
            "row_sum" => $rowSum,
            "formatted_row_sum" => self::format($rowSum),
        ];
    }

    private static function getCount($unit, $product): int
    {
        $orderItem = $product->order?->orderItems?->filter(
            function ($orderItem) use ($unit) {
                return $orderItem->unit_id === $unit['id'];
            }
        );
        return $orderItem->first()->count ?? 0;
    }

    private static function format(float $number): string
    {
        return number_format($number, 2, '.', ' ');
    }

}