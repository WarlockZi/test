<?php

namespace app\model\del;


class Right extends Model {

	public  $table = 'rights';
	public  $model = 'right';

   protected $fillable = [
   	'name' => '',
   	'description' => '',
	];

}
