<?php

namespace app\model;


class Videoinstruction extends Model
{
	public $table = 'videoinstructions';
	public  $model = 'videoinstruction';

	protected $fillable = [
		'name'=>'',
		'link'=>'',
		'user_id'=>null,
		'sort'=>null,
		'tag'=>'',
	];

	public function empty()
	{
		return $this->fillable;
	}
	public static function delete($id)
	{
		return parent::delete($id);
	}
	public static function create($value=[],$register=false,$needsAuth=true)
	{
		return parent::create($value);
	}

}