<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'title',
		'description',
		'keywords',
		'product_categry_1sid',
	];

}
