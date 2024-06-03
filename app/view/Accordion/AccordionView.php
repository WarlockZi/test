<?php

namespace app\view\Accordion;

use app\core\Icon;
use app\model\Opentest;
use app\Repository\TestRepository;

class AccordionView
{
   public static function testDo()
   {
      return AccordionBuilder::build(
         TestRepository::doAccordion(),
         '/adminsc/test/do/'
      )
         ->relation('children')
         ->ulBefore(Icon::arrowUp(). Icon::path())
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
         ->attachAfter(ROOT . '/app/view/Accordion/Admin/edit_add_test_button.php')
         ->get();
   }
}