<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class ProductWithoutAppends extends Model
{
    // model is for cart count products

    protected $table = 'products';
    public function orderItems(): hasManyThrough
    {
        return $this->hasManyThrough(
            OrderItem::class, //дб order_product_id
            OrderProduct::class,
            'product_id',//orderitems
            'order_product_id', //order_product for orderitems
            '1s_id', //proudcts
            'id', //in order_product
        )
            ;
    }

}




