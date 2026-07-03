<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herocategory extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'title',
        'subtitle',
        'category_1s_id',
        'img',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_1s_id', 's_id');
    }

}
