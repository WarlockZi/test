<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Propertable extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'property_id',
        'propertable_type',
        'propertable_id',
        'val_id',
    ];

}