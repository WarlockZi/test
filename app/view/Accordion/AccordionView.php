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
//			->ulAfter("editWhite", '/adminsc/test/edit/')
			->ulAfter(Icon::editWhite(), '/adminsc/test/edit/')
//			->liAfter("editWhite", '/adminsc/test/edit/')
			->liAfter(Icon::editWhite(), '/adminsc/test/edit/')
			->isPathAttr("isTest")
			->attachButtonAfter(ROOT.'/app/view/Accordion/Admin/edit_add-test-button.php')
			->get();
		return $accordion;
	}

	public static function testDo()
	{
		$upload_max_filesize = ini_get("upload_max_filesize");
		$file_uploads = ini_get("file_uploads");
		$post_max_size = ini_get("post_max_size");
//		$up = ini_get("upload_max_filesize");
		$icon = Icon::path();
		return AccordionBuilder::build(
			Test::where('test_id', 0)
				->where('enable', 1)
				->with('children')
				->get(),
			'/adminsc/test/do/'
		)
			->relation('children')
			->ulBefore("<div class='arrow'></div>" . $icon)
//			->ulBefore("<div class='arrow'></div>" . Icon::path())
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
			->ulAfter(Icon::editWhite(), '/adminsc/opentest/edit/')
//			->ulAfter("editWhite", '/adminsc/opentest/edit/')
			->liAfter(Icon::editWhite(), '/adminsc/opentest/edit/')
//			->liAfter("editWhite", '/adminsc/opentest/edit/')
			->isPathAttr("isTest")
			->attachAfter(ROOT.'/app/view/Accordion/Admin/edit_add_test_button.php')
			->get();
	}
}