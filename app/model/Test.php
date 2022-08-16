<?php

namespace app\model;


class Test extends Model
{

	public $table = 'test';
	public $model = 'test';

	public $fillable = [
		'id' => 0,
		'name' => '...',
		'enable' => 0,
		'parent' => 0,
		'isTest' => 1,
	];

	public $hasMany = [];

	public function questions(){
		$id = $this->items[0]['id'];
		return Question::findAllWhere('parent', $id);
	}
	public function getChildren($id)
	{
		$children = $this->findAllWhere('parent', $id);
		return $children;
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
