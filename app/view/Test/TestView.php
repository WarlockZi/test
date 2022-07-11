<?php


namespace app\view\Test;


class TestView
{

	public static function questionParentSelector(int $selected, int $exclude = -1)
	{

		$tests = \app\model\Test::where('isTest', '=', '1')->get();
		$parent_select = '<select>';
		foreach ($tests as $t) {
			$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
			$parent_select .= "<option data-question-parent-id={$t['id']} {$selectedStr}>{$t['name']}</option>";
		}
		$parent_select .= "</select>";

		return $parent_select;
	}
}