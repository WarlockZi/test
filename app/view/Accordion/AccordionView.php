<?php


namespace app\view\Accordion;


use app\core\Icon;
use app\model\Test;

class AccordionView
{

	public static function testEdit()
	{
		return AccordionBuilder::build(
			Test::where('test_id', 0)
				->with('children')
				->get(),
			'/adminsc/question/edit/'
		)
			->relation('children')
			->class('accordion_wrap')

			->ulBefore("<div class='arrow'></div>".Icon::path())
			->ulAfter( "editWhite",'/adminsc/test/edit/')

			->liAfter("editWhite",'/adminsc/test/edit/')
			->isPathAttr("isTest")
//			->liBefore("path",)
			->get();

//		$accordion = new Accordion([
//			'model' => Test::class,
//			'models' => Test::where('test_id', 0)
//				->with('children')
//				->get()
//				->toArray(),
//
//			'childName' => 'children',
//			'class' => 'test-edit accordion_wrap',
//			'label_after' => ICONS . "/edit.svg",
//			'link' => '/adminsc/question/edit/',
//			'link_label_after' => '/adminsc/test/edit/',
//
//		]);
//
//		return $accordion->getHtml();
	}

	public static function testDo()
	{
		return AccordionBuilder::build(
			Test::where('test_id', 0)
				->where('enable', 1)
				->with('children')
				->get(),
			'/adminsc/question/edit/'
		)
			->relation('children')
			->class('accordion_wrap')

			->ulBefore("<div class='arrow'></div>".Icon::path())
//			->ulAfter( "editWhite",'/adminsc/test/edit/')

			->liAfter("editWhite",'/adminsc/test/edit/')
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
//
//		]);
//
//		return $menu->getHtml();
	}
}