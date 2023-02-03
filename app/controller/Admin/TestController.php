<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Test;
use app\view\OpenTest\OpentestView;
use app\view\View;


class TestController extends AppController
{
  public function actionDo(): void
  {
    $page_name = 'Прохождение тестов';
    $this->set(compact('page_name'));

    if (isset($this->route['id'])) {
      $id = (int)$this->route['id'] ?? 0;
      $test = Test::with('questions.answers')
        ->find($id);

      if ($test) {
        if ($test->questions) {
          foreach ($test->questions as &$question) {
            $question->answers->shuffle();
          }
          $this->cacheCorrectAnswers($test->questions);
        }
        $pagination = Test::pagination($test->questions ?? '');
        $this->set(compact('test', 'pagination'));
      }
      $this->set(compact('test'));
    }
  }

  public function __construct(array $route)
  {
    parent::__construct($route);
  }

  public function actionEdit()
  {
    if ($this->ajax) {
      $id = Test::update($this->ajax);
      $this->exitJson(['id' => $id]);
    }
    if (isset($this->route['id'])) {
      $id = $this->route['id'];
      $item = OpentestView::item($id);
      $this->set(compact('item'));
    }
  }

  public function actionIndex()
  {
    View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
  }

  public function actionPathshow()
  {
    $this->layout = 'admin';
    $this->view = 'edit_show';
    $page_name = 'Создание папки';
    $this->set(compact('page_name'));

    $paths = $this->paths();
    $this->set(compact('paths'));

    $test['isTest'] = 0;
    $rootTests = Test::where('isTest', 0)->get()->toArray();
    $this->set(compact('rootTests', 'test'));
  }

  public function actionGetCorrectAnswers()
  {
    $this->exitJson(($_SESSION['correct_answers']));
  }

//  function shuffle_assoc($array)
//  {
//    $keys = array_keys($array);
//    shuffle($keys);
//    foreach ($keys as $key) {
//      $new[$key] = $array[$key];
//    }
//    return $new;
//  }

  private function getCorrectAnswers( $questions): array
  {
    $correctAnswers = [];
    foreach ($questions as $q) {
      if (isset($q['answers'])) {
        foreach ($q['answers'] as $answer) {
          if ($answer['correct_answer']) {
            $correctAnswers[] = $answer['id'];
          }
        }
      }
    }
    return $correctAnswers;
  }

  private function cacheCorrectAnswers(array $arr): void
  {
    $correctAnswers = $this->getCorrectAnswers($arr);
    $_SESSION['correct_answers'] = $correctAnswers ?? '';
  }

  public function actionPaths()
  {
    exit(json_encode($this->paths()));
  }

  private function paths()
  {
    return Test::where('isTest', '0')->get()->toArray();
  }

  public function actionTests()
  {
    $this->exitJson(Test::where('isTest', '1')->get()->toArray());
  }


}
