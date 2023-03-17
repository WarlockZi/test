<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\model\Propertable;
use app\model\Property;
use app\view\Property\PropertyView;


class PropertyController Extends AppController
{

	public $model = Property::class;

	public function getModel()
  {
    return $this->model;
  }

  public function __construct()
	{			exit('P2');
		parent::__construct();
	}

	public function actionIndex()
	{
		$list = PropertyView::listAll();
		$this->set(compact('list'));
	}

	public function actionEdit()
	{
		if (isset($this->route['id'])) {
			$item = PropertyView::edit($this->route['id']);
			$this->set(compact('item'));
		} else {
			header('Location: /adminsc/property');
		}
	}

	public function actionDelete()
	{
		Propertable::where('property_id',$this->ajax['id'])->delete();
		parent::actionDelete();
	}

}
