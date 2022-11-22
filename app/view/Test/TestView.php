<?php

namespace app\view\Test;

use app\model\Test;
use app\model\Illuminate\Test as illuminateTest;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\MyTree\Tree;

class TestView
{
	protected $model = Test::class;
	protected $illuminateModel = \app\model\Illuminate\Test::class;

	public static function item($id)
	{
		$view =new self();
		$test = $view->illuminateModel::find($id);
		$itemArr = $test->toArray();
		$parents = $test->parents;
		$isTest = $test->isTest?'теста':'папки';
		return ItemBuilder::build($test, 'test')
			->pageTitle("Редактирование {$isTest} - {$test['name']}")
			->del()
			->save()
			->field(
				ItemFieldBuilder::build('id', $test)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $test)
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('enable', $test)
					->name('Показывать')
					->type('select')
					->html(TestView::enabled($itemArr))
					->get()
			)
			->field(
				ItemFieldBuilder::build('parent', $test)
					->name('Принадлежит')
					->html(TestView::belongsTo($itemArr))
					->type('select')
					->get()
			)
			->get();
	}

	public static function enabled($item)
	{
		return SelectBuilder::build()
			->array(['не показывать','показывать'])
			->class('custom-select')
			->field('enable')
			->selected($item['enable'])
			->get();
	}

	public static function belongsTo(array $item)
	{
		$tests = illuminateTest::where('isTest', '0')->get()->toArray();
		$tree = Tree::tree($tests);
		return SelectBuilder::build()
			->tree($tree)
			->class('custom-select')
			->field('parent')
			->initialOption('',0)
			->selected($item['parent'])
			->excluded($item['id'])
			->tab('&nbsp&nbsp')
			->get();

	}

	public static function questionParentSelector(int $selected, int $exclude = -1)
	{
		$tests =
			\app\model\Illuminate\Test::where('isTest', '1')
			->get()->toArray();
		$parent_select = '<select>';
		foreach ($tests as $t) {
			$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
			$parent_select .= "<option data-question-parent-id={$t['id']} {$selectedStr}>{$t['name']}</option>";
		}
		$parent_select .= "</select>";

		return $parent_select;
	}
}