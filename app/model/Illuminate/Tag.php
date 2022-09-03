<?php

namespace app\model\illuminate;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'name', 'comment',
	];


	public function taggable()
	{
		return $this->morphedByMany();
	}


}
