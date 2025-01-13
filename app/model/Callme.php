<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Callme extends Model
{
    public $timestamps = true;
    protected $table = 'callme';

    protected $fillable = [
        'phone',
        'php_session'
    ];

}
