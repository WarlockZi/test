<?php

namespace app\model;

use app\Repository\ImageRepository;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	public $timestamps = true;

	protected $fillable = [
		'name',
		'phone',
		'email',
		'message',
        'done'
	];



}
