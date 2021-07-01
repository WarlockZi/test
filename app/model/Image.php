<?php

namespace app\model;

use app\model\Model;


class Image extends Model
{
	protected $table = 'images';
	protected $model= 'image';
	protected $filable = [
		'hash'=>'',
		'path'=>'',
		'name'=>'',
		'tag'=>'',
		'size'=>'',
		'type'=>'',
		'relatedTo'=>''
	];


}