<?php

namespace app\model;

use http\Encoding\Stream;
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

    protected $attributes=[
        'title'=>'',
        'description'=>'',
        'keywords'=>'',
        'product_categry_1sid'=>'',
    ];


}
