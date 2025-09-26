<?php

namespace app\model\Traits;

use app\model\ProductUnit;
use app\model\Unit;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasFilteredUnits
{
    public function units(): HasMany
    {
        return $this->hasMany(ProductUnit::class, 'product_1s_id', '1s_id');
    }

    public function unitFrom1s(): HasMany
    {
        return $this->units()->where('is_from_1s', 1);
    }

    public function minUnit(): HasMany
    {
        return $this->units()->where('multiplier', 1);
    }

    public function shippableUnits(): HasMany
    {
        return $this->units()->where('is_shippable', 1);
    }
}