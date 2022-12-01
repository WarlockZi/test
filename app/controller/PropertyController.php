<?php

namespace app\controller;


use app\model\IlluminateModelMorphDecorator;
use app\model\Propertable;
use app\model\IlluminateModelDecorator;
use app\model\Property;
use app\view\Property\PropertyView;


class PropertyController Extends AppController
{

	public $illuminateModel = IlluminateProperty::class;
	public $model = Property::class;
	public $table = 'properties';

	public function __construct(array $route)
	{
		parent::__construct($route);
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

	public function actionUpdateOrCreate()
	{

		IlluminateModelMorphDecorator::updateOrCreate(IlluminateProperty::class, $this->ajax);
	}

	public function actionDelete()
	{
		Propertable::where('property_id',$this->ajax['id'])->delete();
		parent::actionDelete();
	}

}
