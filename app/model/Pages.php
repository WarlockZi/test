<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
	public $timestamps = true;

	protected $fillable = [
        'name',
		'seo_title',
        'seo_description',
        'seo_keywords',
        'content'
	];

}