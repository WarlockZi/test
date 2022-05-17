<?php

namespace app\model;


class Right extends Model {

	public  $table = 'rights';
	public  $model = 'right';

   protected $fillable = [
   	'name' => '',
   	'description' => '',
	];

}
