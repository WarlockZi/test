<?php

namespace app\view\Test;

use app\model\Test;
use app\view\components\Builders\SelectBuilder;
use app\view\components\MySelect\MySelect;
use app\view\components\Tree\Tree;

class TestView
{
	protected $model = Test::class;

	public static function enabled($item)
	{
		return SelectBuilder::build($item)
			->class('custom-select')
			->field('enable')
			->selected($item['enable'])
			->tree(['0' => 'не показывать', '1' => 'показывать'])
			->get();
	}

	public static function belongsTo($item)
	{

		$s = Test::findAllWhere('isTest', '0');
		$tree = Tree::tree($s);
		return SelectBuilder::build($item)
			->class('custom-select')
			->field('parent')
			->initialOptionLabel('',-1)
			->selected($item['parent'])
			->excluded($item['id'])
			->tree($tree)
			->tab('&nbsp&nbsp')
			->get();
	}

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