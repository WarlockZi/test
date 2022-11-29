<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Videoinstruction extends Model
{
	public $table = 'videoinstructions';
	public  $model = 'videoinstruction';

	protected $fillable = [
		'name'=>'',
		'link'=>'',
		'user_id'=>0,
		'sort'=>0,
		'tag'=>'',
	];

	public function empty()
	{
		return $this->fillable;
	}

//	public static function create($value=[],$register=false,$needsAuth=true)
//	{
//		return parent::create($value);
//	}

}