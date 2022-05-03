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

	public function actionList()
	{
		$this->view = 'list';

		$items = $this->model::findAll();

		$table = $this->getTable($items)->html;
		$this->set(compact('table'));

	}

	private function getTable($items)
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
				'editCol' => true,
				'delCol' => true,
				'addButton'=> true
			]
		);
	}

	public function actionShow()
	{
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
		}
	}


	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWith("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}


  public function actionEdit()
  {
//    $this->view = 'adminEdit';

    if (User::can($this->user, ['role_employee'])) {
      if (isset($this->route['id'])) {
        $user = User::findOneWhere('id', $this->route['id']);
        $this->set(compact('user'));
      }
      $rights = Right::findAll();
      $this->set(compact('rights'));

      $item = $user;
      $item = include ROOT . '/app/view/User/getItem.php';
      $this->set(compact('item'));

    }
    if ($user = $this->ajax) {
      $user['id'] = $_SESSION['id'];
      User::update($user);
      exit('ok');
    }
  }
	public function actionUpdate()
	{
		if ($this->ajax) {
			$updated = $this->model::update($this->ajax);
			$this->exitWith('ok' );
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

	}
}
