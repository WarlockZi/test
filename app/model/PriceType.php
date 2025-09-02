<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{
    public $timestamps = false;
    protected $table = 'price-types';

    protected $fillable = [
        'type',
        'web-name',
    ];

}