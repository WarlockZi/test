<?php

namespace app\view\share\shippable;


use app\model\Product;

class ShippableUnitsTableFactory
{
    private ShippableUnitsTable $self;
    private Product|array $product;
    private ShippableUnitsTable $table;

    public function __construct(Product|array $product)
    {
        $this->product = $product;
    } 

    public static function create(Product|array $product, string $module): string
    {
        $self        = new self($product);
        $self->table = new ShippableUnitsTable($product);
        if ($module === 'product') {
            return $self->table->blueButton()
                ->fontSize(1)
                ->greenButton()
                ->desription()
                ->totalRowSum()->get();
        } elseif ($module === 'category') {
            return $self->table->blueButton()->greenButton()->desription()->get();

        }
        return $self->table->desription()->get(); //cart

    }

}