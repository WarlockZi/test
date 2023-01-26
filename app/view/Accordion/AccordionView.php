<?php


namespace app\view\Accordion;


use app\model\Test;

class AccordionView
{

	public static function testEdit()
	{

		$tests = Test::where('test_id', 0)
//			->with('childrenRecursive')
			->with('children')
			->get()
			->toArray();

		$accordion = new Accordion([
			'model' => Test::class,
			'models' => $tests,

			'childName' => 'children',
			'class' => 'test-edit',
			'label_after' => ICONS . "/edit.svg",
			'link' => '/adminsc/question/edit/',
			'link_label_after' => '/adminsc/test/edit/',

		]);

		return $accordion->getHtml();
	}

	public static function testDo()
	{
		$menu = new Accordion([

			'models' =>
				Test::where('test_id', 0)
					->where('enable', 1)
					->with('childrenRecursive')
					->get()
					->toArray(),
			'class' => 'test-edit',
			'label_after' => "",
			'link' => "/test/do/",
			'childName' => 'children_recursive',

		]);

//		return "<div class='accordion_wrap'>{$menu->getHtml()}</div>";
		return $menu->getHtml();
	}
}