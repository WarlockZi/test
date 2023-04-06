<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\model\Planning;
use app\model\Todo;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\CustomList\CustomList;
use app\view\Planning\PlanningView;

class PlanningController Extends AppController
{
	public $modelName = Todo::class;
	public $model = 'todo';

	public function __construct()
	{
		parent::__construct();
	}


	public function actionCreate()
	{
		$items = Todo::where('type', 'день')->
		where('user_id', Auth::getUser())->
		get();
		$daily = PlanningView::list($items);
		$this->set(compact('daily'));
	}

	public function actionList()
	{
		$daily = PlanningView::listDaily(Todo::class);
		$weekly = PlanningView::listWeekly(Todo::class);
		$yearly = PlanningView::listYearly(Todo::class);
		$this->set(compact('daily','weekly','yearly'));
	}

	private function getTable($items)
	{

	}

	public function actionIndex()
	{

	}

}
