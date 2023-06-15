<?php


namespace app\Actions;


use app\model\Category;

class CategoryAction
{

	public static function changeProperty(array $req)
	{
		$category = Category::find($req['category_id']);
		$newVal = $req['morphed']['new_id'];
		$oldVal = $req['morphed']['old_id'];

		if (!$oldVal) {
			$category->values()->attach($newVal);
			exit(json_encode(['popup' => 'Добавлен']));

		} else if (!$newVal) {
			$category->values()->detach($oldVal);
			exit(json_encode(['popup' => 'Удален']));

		} else {
			if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
			$category->properties()->detach($oldVal);
			$category->properties()->attach($newVal);
			exit(json_encode(['popup' => 'Поменян']));
		}
	}

}