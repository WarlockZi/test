<?php


namespace app\view\Accordion;


use app\core\Icon;
use app\model\Opentest;
use app\model\Test;

class AccordionView
{

	public static function opentestEdit()
	{
		return AccordionBuilder::build(
			Opentest::where('opentest_id', 0)
				->with('children')
				->get(),
			'/adminsc/openquestion/edit/'
		)
			->relation('children')
			->class('test-edit')
			->ulBefore("<div class='arrow'></div>" . Icon::path())
			->ulAfter("editWhite", '/adminsc/opentest/edit/')
			->liAfter("editWhite", '/adminsc/opentest/edit/')
			->isPathAttr("isTest")
			->get();
	}

	public static function testEditAccordion()
	{

		$accordion =AccordionBuilder::build(
			Test::where('test_id', 0)
				->with('children')
				->get(),
			'/adminsc/question/edit/'
		)
			->relation('children')
			->class('test-edit')
			->ulBefore("<div class='arrow'></div>" . Icon::path())
			->ulAfter("editWhite", '/adminsc/test/edit/')
			->liAfter("editWhite", '/adminsc/test/edit/')
			->isPathAttr("isTest")
			->get();

		$button = self::getButton();

		return "<div class='accordion_wrap'>{$accordion}{$button}</div>";
	}

	private static function getButton()
	{
		ob_start();
		include ROOT . '/app/view/Test/edit_add-test-button.php';
		return ob_get_clean();
	}




	public static function testDo()
	{
		return AccordionBuilder::build(
			Test::where('test_id', 0)
				->where('enable', 1)
				->with('children')
				->get(),
			'/adminsc/test/do/'
		)
			->relation('children')
			->class('accordion_wrap')
			->ulBefore("<div class='arrow'></div>" . Icon::path())
			->isPathAttr("isTest")
//			->liBefore("path",)
			->get();

//		$menu = new Accordion([
//
//			'models' =>
//				Test::where('test_id', 0)
//					->where('enable', 1)
//					->with('childrenRecursive')
//					->get()
//					->toArray(),
//			'class' => 'accordion_wrap',
//			'label_after' => "",
//			'link' => "/test/do/",
//			'childName' => 'children_recursive',
//		]);
//		return $menu->getHtml();
//		$accordion = new Accordion([
//			'model' => Test::class,
//			'models' => Test::where('test_id', 0)
//				->with('children')
//				->get()
//				->toArray(),
//			'childName' => 'children',
//			'class' => 'test-edit accordion_wrap',
//			'label_after' => ICONS . "/edit.svg",
//			'link' => '/adminsc/question/edit/',
//			'link_label_after' => '/adminsc/test/edit/',
//		]);
//
//		return $accordion->getHtml();
	}
}