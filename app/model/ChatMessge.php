<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChatMessge extends Pivot
{
	public $timestamps = true;

	protected $fillable = [
		'user_name',
        'php_session'
	];

    public function comments()
    {
        $this->hasMany('');
    }
}
