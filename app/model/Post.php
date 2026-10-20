<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'name',
        'full_name',
        'post_id',
        'hired',
        'fired',
    ];

    public function chief()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }


}
