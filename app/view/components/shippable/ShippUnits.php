<?php

namespace app\view\components\shippable;

use app\model\Product;
use app\model\Unit;

class ShippUnits
{
    private Product $product;
    private float $price;
    private Unit $baseUnit;
    private int $totalRowSum = 0;


    public static function row($product, $unit): array
    {
        $self           = new self();
        $self->product  = $product;
        $self->price    = (float)$product->price;
        $order          = $self->product?->order;
        $self->baseUnit = $self->product->baseUnit;

        $orderItem  = $order
            ? $order?->orderItems->filter(function ($item) use ($unit) {
                return $item->unit_id === $unit['id'];
            })?->first()
            : null;
        $count      = $order ? $self->getCount($unit) : 0;
        $multiplier = $unit->pivot->multiplier ?? 1;

        return [
            'orderItem' => $orderItem,
            "unit" => $unit,
            "baseUnit" => $self->baseUnit->name,
            "count" => $count,
            "price" => $self->price,
            "multiplier" => number_format($multiplier, 0, '', ' '),
            "cost" => $self->format($multiplier * (float)$self->price),
            "formattedCost" => $self->format($self->price * $multiplier),
            "totalRowSum" => $self->getRowSum($count, $multiplier),
        ];
    }

    private function getRowSum(int $count, int $multiplier): string
    {
        if ($this->totalRowSum) {
            $rowSum = $this->format($multiplier * $this->price * $count);
            return "<div class='sub-sum' sub-sum>{$rowSum}</div>";
        }
        return '';
    }

    private function getCount($unit)
    {
        $orderItem = $this->product->order?->orderItems?->filter(
            function ($order) use ($unit) {
                return $order->unit_id === $unit['id'];
            }
        );
        return $orderItem->first()->count ?? 0;
    }

    private function format(float $number): string
    {
        return number_format($number, 2, '.', ' ');
    }

}