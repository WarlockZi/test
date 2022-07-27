<?php

namespace app\view\Test;

use app\model\Test;
use app\view\components\Builders\Item\ItemFieldBuilder;
use app\view\components\Builders\SelectBuilder;
use app\view\components\MyItem\MyItem;
use app\view\components\Tree\Tree;

class TestView
{
	protected $model = Test::class;

	public static function item($id)
	{
		$view =new self();
		$item = new $view->model;
		$item = $item::find($id)[0];
		return MyItem::build($view->model, $id)
			->del()
			->save()
			->field(
				ItemFieldBuilder::build('id')
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('enable')
					->name('Показывать')
					->type('select')
					->html(TestView::enabled($item))
					->get()
			)
			->field(
				ItemFieldBuilder::build('parent')
					->name('Принадлежит')
					->html(TestView::belongsTo($item))
					->type('select')
					->get()
			)
			->get();
	}

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
			->initialOptionLabel('',0)
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