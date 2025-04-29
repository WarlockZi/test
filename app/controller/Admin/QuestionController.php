<?php

namespace app\controller\Admin;

use app\Factory\AbstractTestFactory;
use app\Factory\TestFactory;
use app\model\Question;
use app\service\Response;
use app\service\Router\Router;
use app\service\Test\TestDoService;
use app\service\Test\TestEditService;


class QuestionController extends AdminscController
{
    protected string $model = Question::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionEdit()
    {
        $id = Router::getRoute()->id;
        if ($id) {
            $test = new TestEditService();

            $page_name = 'Редактирование тестов';
            $this->setVars(compact('page_name'));

            $this->setVars(compact('test'));
        }
    }

    public function actionSort()
    {
        $q_ids = $this->ajax['toChange'];
        Question::sort($q_ids);
        Response::exitWithPopup('Сортировка сохранена');
    }

}
