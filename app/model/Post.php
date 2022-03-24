<?php

namespace app\model;

class Post extends Model {

   protected $table = 'posts';

   protected $fillable = [
   	'name' => '',
   	'chief' => null,
   	'subordinate' => null,
	];

}
