<?php


namespace app\view\Test;


class TestView
{

	public static function isTestSelector(int $selected, int $exclude = -1)
	{
		$parent_select = \app\core\Cache::get('parent_select');
		if (!$parent_select) {
			$tests = \app\model\Test::where('isTest', '=', '1')->get();
			$parent_select = '<select>';
			foreach ($tests as $t) {
				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
				$parent_select .= "<option data-question-parent-id={$t['id']} {$selectedStr}>{$t['name']}</option>";
			}
			$parent_select .= "</select>";
			\app\core\Cache::set('parent_select', $parent_select, 6);
		}
		return $parent_select;
	}
}