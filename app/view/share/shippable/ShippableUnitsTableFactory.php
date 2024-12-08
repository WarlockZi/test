<?php

namespace app\view\share\shippable;


use app\model\Order;
use app\model\OrderItem;

class ShippableUnitsTableFactory
{
    private ShippableUnitsTable $self;

    private OrderItem $orderItem;
    private ShippableUnitsTable $table;


    public function __construct(OrderItem $order)
    {
        $this->order = $order;
    }

    public static function create(OrderItem $orderItem, string $module,): string
    {
        $self        = new self($orderItem);
        $self->table = new ShippableUnitsTable($orderItem);
        if ($module === 'product') {
            return $self->table->blueButton()->fontSize(1)->greenButton()->desription()->totalRowSum()->get();
        } elseif ($module === 'category') {
            return $self->table->blueButton()->greenButton()->desription()->get();
        } elseif ($module === 'cart') {
            return $self->table->desription()->get(); //cart
        }
        return '';
    }
}