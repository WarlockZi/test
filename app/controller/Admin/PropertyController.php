<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Propertable;
use app\model\Property;
use app\view\Property\PropertyView;


class PropertyController Extends AppController
{
	public $model = Property::class;
    public function __construct()
{
    parent::__construct();
}

	public function actionIndex():void
	{
		$list = PropertyView::listAll();
		$this->set(compact('list'));
	}

	public function actionEdit()
	{
		if ($this->route->id) {
			$item = PropertyView::edit($this->route->id);
			$this->set(compact('item'));
		} else {
			header('Location: /adminsc/property');
		}
	}

	public function actionDelete():void
	{
		Propertable::where('property_id',$this->ajax['id'])->delete();
		parent::actionDelete();
	}

//	public function getModel()
//  {
//    return $this->model;
//  }
}
