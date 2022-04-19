<?php

namespace app\model;


class Right extends Model {

   protected $table = 'rights';
   protected $model = 'right';

   protected $fillable = [
   	'name' => '',
   	'description' => '',
	];

}
