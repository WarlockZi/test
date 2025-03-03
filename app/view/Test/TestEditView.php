<?php

namespace app\view\Test;

use app\core\FS;
use app\core\Icon;
use app\model\Test;
use app\Repository\TestRepository;
use app\view\Accordion\AccordionBuilder;
use app\view\Accordion\AccordionView;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Collection;


class TestEditView
{
   private FS $fs;
   protected string $accordion = '';
   protected string $pagination = '';
   protected Test $test;
   protected string $content;

   protected string $title = '<h2>Выберите тест</h2>';

   public function __construct()
   {
      $this->fs = new FS(__DIR__);

      $this->accordion = AccordionView::testDo();
   }

   public function getContent($id): string
   {
      $this->test = TestRepository::findById($id);
      $this->content = FS::getFileContent(ROOT . '/app/view/Test/Admin/do_test-data.php', compact('test'));
      return $this->content;
   }

   public function getAccordion(): string
   {
      return $this->accordion;
   }

   public function getPagination($id): string
   {
      $pagination = $this->pagination($test->questions);
      $pagination = "<div class='navigation'>" .
         "<div class='test-name' data-test-id={$test->id}>{$test->name}</div>" .
         "{$pagination}</div>";
      $this->pagination = $pagination;
      $test = TestRepository::do($id);
      return $this->pagination;
   }


   public function testEdit(): string
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
         ->ulAfter(Icon::editWhite(), '/adminsc/test/edit/')
         ->liAfter(Icon::editWhite(), '/adminsc/test/edit/')
         ->isPathAttr("isTest")
         ->attachButtonAfter(ROOT . '/app/view/Accordion/Admin/edit_add-test-button.php')
         ->get();
      return $this->clean($accordion);
   }

   public function item(Test $test): string
   {
      $isTest = $test->isTest ? 'тест' : 'папку';

      return $this->clean(ItemBuilder::build($test, 'test')
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
               ->html($this->testSelector($test->test_id, $test->id))
               ->get()
         )
         ->tab(ItemTabBuilder::build('Вопросы')
            ->html($this->getTestContent($test->id))
         )
         ->get()
      );
   }

   public function getTestContent(int $id): string
   {
      $h = new TestDoService($id);
      return "<div class='test-do'>" . $h->getPagination() . $h->getContent() . "</div>";
   }

   public function pagination(Collection $questions): string
   {
      $pagination = '';
      $i = 0;
      foreach ($questions as $id => $el) {
         $i++;
         $d = "<div data-pagination={$el['id']}>{$i}</div>";
         $pagination .= $d;
      }

      return "<div class='pagination'>{$pagination}</div>";
   }

   public function testSelector(int $selected, int $excluded): string
   {
      return $this->clean(SelectBuilder::build(
         TreeOptionsBuilder::build(TestRepository::treeAll(), 2)
            ->initialOption()
            ->selected($selected)
            ->excluded($excluded)
            ->get()
      )
         ->field('test_id')
         ->get()
      );
   }

}