<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Openquestion;
use app\model\Opentest;
use app\view\OpenTest\OpentestView;


class OpenquestionController Extends AppController
{
	private $model = Openquestion::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionEdit()
	{
		$page_name = 'Редактирование открытых тестов';
		$this->set(compact('page_name'));

		$id = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($id) {
			$test = Openquestion::with('questions.answers')
				->find($id);

			$parentSelector = OpentestView::questionParentSelector($test->id);

			$this->set(compact('test','parentSelector'));
		}
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Openquestion::sort($q_ids);
		$this->exitWithPopup('Сортировка сохранена');
	}


}
