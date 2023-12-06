<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	protected $fillable = ['name', 'value', 'title',];
	public $timestamps = false;
}
