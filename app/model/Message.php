<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	public $timestamps = true;

	protected $fillable = [
		'user_id',
		'chat_id',
        'message'
	];

    public function chat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
