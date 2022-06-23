<?php

namespace app\controller;

use app\model\Right;
use app\model\User;
use app\view\View;
use app\view\components\CustomList\CustomList;


class RightController Extends AppController
{
	protected $model = Right::class;
	protected $modelName = 'right';
	protected $tableName = 'rights';

	public function __construct(array $route)
	{
		parent::__construct($route);

		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
	}
  public function actionUpdateOrCreate()
  {
    if ($this->ajax) {
      if ($id = Right::updateOrCreate($this->ajax)) {
        if (is_bool($id)) {
          $this->exitWithPopup('Сохранено');
        }else{
          $this->exitJson(['id'=>$id,'msg'=>'Создан']);
        }
      }
    }
  }


	public function actionList()
	{
		$this->view = 'list';

		$items = $this->model::findAll();

		$list = $this->getList($items)->html;
		$this->set(compact('list'));

	}

	private function getList($items)
	{
		return new CustomList(
			[
				'models' => $items,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type'=>'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
				'delCol' => true,
				'addButton'=> 'ajax'
			]
		);
	}

	public function actionShow()
	{
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)-1) {
				$this->exitJson(['id'=>$id]);
			}
		}
	}



	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWithPopup("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}



	public function actionUpdate()
	{
		if ($this->ajax) {
			$updated = $this->model::update($this->ajax);
			$this->exitWithPopup('ok' );
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

	}
}
