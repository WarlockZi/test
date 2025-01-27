<?php

namespace app\controller\Admin;

use app\core\Response;
use app\model\Test;
use app\Repository\AnswerRepository;
use app\Repository\TestRepository;
use app\view\Test\TestView;
use app\view\View;


class TestController extends AdminscController
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
            $test = TestRepository::do($id);
            AnswerRepository::cacheCorrectAnswers(Test::find($id));
            $testView = $this->testView;
            $this->setVars(compact('test', 'testView'));
        } else {
            $this->view = 'index';
            $tests      = $this->repository->treeAll();
            $testView   = $this->testView;
            $this->setVars(compact('tests', 'testView'));
        }

    }


    public function actionEdit(): void
    {
        $id = $this->route->id;

        if ($id) {
            $this->route->setView('edit/edit');
            $test     = TestRepository::do($id);
            $testView = $this->testView;
            $this->setVars(compact('test', 'testView'));
        } else {
            $this->view = 'index';
            $tests      = $this->repository->treeAll();
            $testView   = $this->testView;
            $this->setVars(compact('tests', 'testView'));
        }

//      $test = TestRepository::findById($id);
//      if ($test) $test = $this->testView->item($test);
//      $accordion = $this->testView->getAccordion();
//      $this->set(compact('test', 'accordion'));
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

        $this->setVars(compact('rootTests', 'page_name', 'paths', 'test'));
    }

    public function actionGetCorrectAnswers()
    {
        Response::json(($_SESSION['correct_answers']));
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
        Response::json(Test::where('isTest', '1')->get()->toArray());
    }


}
