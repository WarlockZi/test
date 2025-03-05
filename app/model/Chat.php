<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
	public $timestamps = true;

	protected $fillable = [
		'user_name',
        'php_session'
	];

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }
}
