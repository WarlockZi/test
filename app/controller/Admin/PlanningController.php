<?php

namespace app\controller\Admin;

use app\model\Todo;
use app\Services\AuthService\Auth;
use app\view\Planning\PlanningView;

class PlanningController extends AdminscController
{
    public $modelName = Todo::class;
    public string $model = 'todo';

    public function __construct()
    {
        parent::__construct();
    }

    public function actionCreate()
    {
        $items = Todo::where('type', 'день')->
        where('user_id', Auth::getUser())->
        get();
        $daily = PlanningView::listDaily($items);
        $this->setVars(compact('daily'));
    }

    public function actionIndex(): void
    {
        $daily  = PlanningView::listDaily();
        $weekly = PlanningView::listWeekly();
        $yearly = PlanningView::listYearly();
        $this->setVars(compact('daily', 'weekly', 'yearly'));
    }

}
