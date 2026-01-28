<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        '1s_name',
        'web_name',
        'international_name',
    ];

    public function price(): belongsTo
    {
        return $this->belongsTo(
            Price::class
        );
    }


}