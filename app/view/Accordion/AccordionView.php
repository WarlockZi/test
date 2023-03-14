<?php


namespace app\view\Accordion;


use app\core\FS;
use app\core\Icon;
use app\model\Opentest;
use app\model\Test;

class AccordionView
{
	public static function testEdit()
	{
		$accordion = AccordionBuilder::build(
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
			->attachButtonAfter(ROOT.'/app/view/Accordion/Admin/edit_add-test-button.php')
			->get();
		return $accordion;
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
			->ulBefore("<div class='arrow'></div>" . Icon::path())
			->isPathAttr("isTest")
			->get();
	}

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
			->attachAfter(ROOT.'/app/view/Accordion/Admin/edit_add_test_button.php')
			->get();
	}
}