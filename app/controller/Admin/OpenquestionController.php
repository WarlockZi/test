<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Route;
use app\model\Opentest;


class OpenquestionController Extends AppController
{
  public function __construct()
  {
    parent::__construct();
  }

  public function actionEdit()
  {
    $page_name = 'Редактирование jnrhsns] тестов';
    $this->set(compact('page_name'));

    if (isset($this->route['id'])) {
      $id = (int)$this->route['id'] ?? 0;
      $test = Opentest::with('questions.answers')
        ->orderBy('sort')
        ->find($id);

      $this->set(compact('test'));
    }
  }

  public function actionSort()
  {
    $q_ids = $this->ajax['toChange'];
    Opentest::sort($q_ids);
    $this->exitWithPopup('Сортировка сохранена');
  }


}
