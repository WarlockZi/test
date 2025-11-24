<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'image_id',
        'product_id',
        'name'
    ];

}