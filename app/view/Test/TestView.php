<?php

namespace app\view\Test;

use app\model\Test;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\MyTree\Tree;
use Illuminate\Database\Eloquent\Model;

class TestView
{
//	protected $model = Test::class;

	public static function item($id)
	{
		$view = new self();
		$test = Test::find($id);

		$parents = $test->parents;
		$isTest = $test->isTest ? 'теста' : 'папки';
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
					->html(TestView::enabled($test))
					->get()
			)
			->field(
				ItemFieldBuilder::build('parent', $test)
					->name('Принадлежит')
					->html(TestView::belongsTo($test))
					->type('select')
					->get()
			)
			->get();
	}

	public static function enabled(Test $item)
	{
		return SelectBuilder::build()
			->array(['не показывать', 'показывать'])
			->class('custom-select')
			->field('enable')
			->selected($item['enable'])
			->get();
	}

	public static function belongsTo(Model $item)
	{
		$treeRelaion = 'children';

		$tree = Test::where('isTest', '0')
			->where('parent',0)
			->with(
				[$treeRelaion => function ($q) {
					$q->where('isTest', '0');}				]
			)->get();

		return SelectBuilder::build()
			->tree($tree, $treeRelaion,null, 4)
			->field('parent')
			->initialOption('', 0)
			->selected($item->parent)
			->excluded($item->id)
			->get();

	}

	public static function questionParentSelector(int $selected, int $exclude = -1)
	{
		$tests =
			Test::where('isTest', '1')
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