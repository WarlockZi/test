<?php

namespace app\model;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'id','name','enable','test_id','isTest',
	];


	public function questions()
	{
		return $this->hasMany(Question::class)->orderBy('sort');
	}

	public function parent()
	{
		return $this->belongsTo(Test::class, 'test_id');
	}

	public function children()
	{
		return $this->hasMany(Test::class, 'test_id')->with('children');
	}

	public function childrenRecursive(){
	  return $this->hasMany(Test::class, 'test_id')->with('children');
  }

	public static function pagination(Collection $items)
	{
		$pagination = '<div class="pagination">';
		$i = 0;
		foreach ($items as $id => $el) {
			$i++;
			$d = "<div data-pagination={$el['id']}>{$i}</div>";
			$pagination .= $d;
		}

		return $pagination . '</div>';
	}
}
