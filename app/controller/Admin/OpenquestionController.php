<?php

namespace app\controller\Admin;

use app\model\Opentest;
use app\service\Response;
use app\service\Router\Router;


class OpenquestionController extends AdminscController
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
