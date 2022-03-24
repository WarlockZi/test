<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Planning extends Model
{
	protected $table = 'planning';
	protected $model = 'planning';
	protected $fillable = [
		'employee'=>null,
		'plan'=>'',
		'do'=>[],
	];

	public static function delete($id)
	{
		return parent::delete($id);

	}
	public static function create($value=[])
	{
		return parent::create($value);
	}

}