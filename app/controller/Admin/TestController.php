<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\core\Router;


use app\model\Test;
use app\Repository\TestRepository;
use app\Services\Test\TestDoService;
use app\view\Test\TestView;
use app\view\View;


class TestController extends AppController
{
   private TestView $testView;
   private TestRepository $repository;

   public function __construct()
   {
      parent::__construct();
      $this->repository = new TestRepository();
      $this->testView   = new TestView();
   }

   public function actionDo(): void
   {
      $id = $this->route->id;
      if ($id) {
         $testService = new TestDoService($id);
         $this->set(compact('testService'));
      } else {
         $this->route->setView('index');
         $tests = $this->repository->treeAll();
         $this->set(compact('tests'));
      }

   }


   public function actionEdit(): void
   {
      $id   = $this->route->id;
      $test = TestRepository::findById($id);
      if ($test) $test = $this->testView->item($test);
      $accordion = $this->testView->getAccordion();
      $this->set(compact('test', 'accordion'));
   }

   public function actionIndex(): void
   {
      View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
   }

   public function actionPathshow()
   {
      $this->layout = 'admin';
      $this->view   = 'edit_show';
      $page_name    = 'Создание папки';

      $paths = $this->paths();

      $test['isTest'] = 0;
      $rootTests      = Test::where('isTest', 0)->get()->toArray();

      $this->set(compact('rootTests', 'page_name', 'paths', 'test'));
   }

   public function actionGetCorrectAnswers()
   {
      Response::exitJson(($_SESSION['correct_answers']));
   }


//   public function actionPaths()
//   {
//      exit(json_encode($this->paths()));
//   }

   private function paths()
   {
      return Test::where('isTest', '0')->get()->toArray();
   }

   public function actionTests()
   {
      Response::exitJson(Test::where('isTest', '1')->get()->toArray());
   }


}
