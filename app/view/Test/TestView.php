<?php

namespace app\view\Test;

use app\model\Test;
use app\Repository\TestRepository;
use app\Services\Test\TestDoService;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;
use Illuminate\Database\Eloquent\Collection;

class TestView
{

	public static function testHead()
	{
		include ROOT . '/app/view/Test/test_head.php';
	}

	public static function item(Test $test)
	{
		$isTest = $test->isTest ? 'тест' : 'папку';

		return ItemBuilder::build($test, 'test')
			->pageTitle("Редактировать {$isTest} - {$test['name']}")
			->del()
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
					->html(
						CheckboxBuilder::build(
							'enable',
							$test->enable,
						)->get()
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('parent', $test)
					->name('Принадлежит')
					->html(self::testSelector($test->test_id, $test->id))
					->get()
			)
			->tab(ItemTabBuilder::build('Вопросы')
				->html(self::getTestContent($test->id))
			)

			->get();
	}

	public static function getTestContent(int $id)
	{
		$h = new TestDoService($id);
		return "<div class='test-do'>".$h->getPagination().$h->getContent()."</div>";
	}

	public static function pagination(Collection $questions)
	{
		$pagination = '<div class="pagination">';
		$i = 0;
		foreach ($questions as $id => $el) {
			$i++;
			$d = "<div data-pagination={$el['id']}>{$i}</div>";
			$pagination .= $d;
		}

		return $pagination . '</div>';
	}

	public static function testSelector(int $selected, int $excluded): string
	{
		return SelectBuilder::build(
			TreeOptionsBuilder::build(TestRepository::treeAll(), 'children', 2)
				->initialOption()
				->selected($selected)
				->excluded($excluded)
				->get()
		)
			->field('test_id')
			->get();
	}

//	public static function questionParentSelector(int $selected, int $exclude = -1)
//	{
//		$tests =
//			Test::where('isTest', '1')
//				->get()->toArray();
//		$parent_select = '<select>';
//		foreach ($tests as $t) {
//			$selected = $t['id'] == $selected ? 'selected' : '';
//			$parent_select .= "<option data-question-parent-id={$t['id']} {$selected}>{$t['name']}</option>";
//		}
//
//		return $parent_select .= "</select>";
//	}
}