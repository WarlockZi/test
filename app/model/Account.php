<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'vitex_guest_id',
        'user_id',
        'vitex_yandex_id',
    ];

}
