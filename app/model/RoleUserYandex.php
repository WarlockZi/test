<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUserYandex extends Pivot
{
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'vitex_yandex_id',
    ];

}