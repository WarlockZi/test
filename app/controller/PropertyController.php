<?php

namespace app\controller;


use app\model\Illuminate\Product;
use app\model\Property;
use app\view\Property\PropertyView;
use \app\model\Illuminate\Property as IlluminateProperty;


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

//	public function actionUpdateOrCreate()
//	{
//		if ($this->ajax) {
//			$model = 'app\model\Illuminate\\' . ucfirst($this->ajax['morph_type']);
//			$product = $model::find($this->ajax['morph_id']);
//			if ($mod = $product->properties()->create()) {
//				$this->exitJson(['popup' => 'Сохранен', 'id' => $mod->id]);
//			} else {
//				$this->exitWithPopup('Сохранено');
//			}
//			$this->exitWithError('Ответ не сохранен');
//		}
//	}

	public function actionDelete()
	{
		if ($this->ajax['id']) {
			if ($this->model::delete($this->ajax['id'])) {
				$this->exitWithPopup('Категория удален');
			}
		} else {
			$this->exitWithMsg('No id');
		}
	}

}
