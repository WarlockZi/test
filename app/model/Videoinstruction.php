<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Videoinstruction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'link',
        'user_id',
        'sort',
        'tag',
    ];

    protected $attributes = [
        'name' => 'видео',
        'link' => 'https://youtube.com'
    ];

    public function empty()
    {
        return $this->fillable;
    }


}