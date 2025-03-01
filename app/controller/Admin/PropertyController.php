<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Propertable;
use app\model\Property;
use app\view\Property\PropertyView;


class PropertyController Extends AdminscController
{
	public string $model = Property::class;
    public function __construct()
{
    parent::__construct();
}

	public function actionIndex():void
	{
		$list = PropertyView::index();
		$this->setVars(compact('list'));
	}

	public function actionEdit()
	{
        $this->view = 'table';
		if ($this->route->id) {
			$table = PropertyView::edit($this->route->id);
			$this->setVars(compact('table'));
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
