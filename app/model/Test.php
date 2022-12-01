<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'id','name','enable','parent','isTest',
	];

	public $hasMany = [];

	public function questions()
	{
		return $this->hasMany(Question::class)->orderBy('sort');
	}

	public function parent()
	{
		return $this->belongsTo(Test::class, 'parent');
	}

	public function getChildren($id)
	{
		return $this->hasMany(Test::class, 'parent');
	}

	public static function pagination(array $items)
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
