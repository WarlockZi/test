<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users(): hasMany
    {
        return $this->hasMany(User::class);
//        return $this->belongsToMany(User::class);
    }

    public function yandex_users(): hasMany
    {
        return $this->hasMany(UserYandex::class);
//        return $this->belongsToMany(UserYandex::class);
    }

    public function cart_items(): hasMany{
        return $this->hasMany(OrderItem::class);
    }
    public function scopeCartItems($query){
        return $query->with(['cart_items' => function($query){
            return $query->with('product.shippableUnits')
//                ->WithUnitDetails()
                ->with('unit')
                ;
        }]);
    }
}
