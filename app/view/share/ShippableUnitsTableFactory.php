<?php

namespace app\view\share;


use app\model\Product;

class ShippableUnitsTableFactory
{
    private ShippableUnitsTable $self;
    private Product $product;
    private ShippableUnitsTable $table;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public static function create(Product $product, string $module, ): string
    {
        $self        = new self($product);
        $self->table = new ShippableUnitsTable($product);
        if ($module === 'product') {
            return $self->table->blueButton()->greenButton()->rowSum()->totalBottom()->get();
        } elseif ($module === 'category') {
            return $self->table->blueButton()->greenButton()->get();

        }
        return $self->table->get(); //cart

    }

}