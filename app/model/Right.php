<?php

namespace app\model;

use app\core\App;
use app\model\Model;

class Right extends Model {

   protected $table = 'rights';

   private $fillable = [
   	'name' => '',
   	'description' => '',
	];

}
