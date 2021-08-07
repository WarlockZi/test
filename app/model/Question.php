<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Question extends Model
{
	public $table = 'question';

	protected $fillable = [
		'qustion'=>'',
		'parent'=>null,
		'picq'=>'',
		'sort'=>'100'
	];

}