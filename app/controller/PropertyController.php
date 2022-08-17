<?php

namespace app\controller;


use app\model\Illuminate\IlluminateModelMorphDecorator;
use app\model\Illuminate\Product;
use app\model\Illuminate\Property as IlluminateProperty;
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
		$id = $this->route['id'];
		$item = PropertyView::edit($id);
		$this->set(compact('item'));
	}

	public function actionUpdateOrCreate()
	{

		IlluminateModelMorphDecorator::updateOrCreate(IlluminateProperty::class,$this->ajax);
	}



}
