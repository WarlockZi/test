<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\core\Router;
use app\model\Opentest;


class OpenquestionController Extends AdminscController
{
  public function __construct()
  {
    parent::__construct();
  }

  public function actionEdit()
  {
    $page_name = 'Редактирование jnrhsns] тестов';
    $this->setVars(compact('page_name'));

    $id = Router::getRoute()->id;

    if ($id) {
      $test = Opentest::with('questions.answers')
        ->orderBy('sort')
        ->find($id);

      $this->setVars(compact('test'));
    }
  }

  public function actionSort()
  {
    $q_ids = $this->ajax['toChange'];
    Opentest::sort($q_ids);
    Response::exitWithPopup('Сортировка сохранена');
  }


}
