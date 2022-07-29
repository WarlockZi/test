<?php

namespace app\controller;


use app\model\Property;
use app\view\Property\PropertyView;
use app\view\View;


class PropertyController Extends AppController
{

	private $model = Property::class;
	private $table = 'properties';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
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
		if ($this->ajax) {
			$id = $this->model::updateOrCreate($this->ajax);
			if (is_numeric($id)) {
				$this->exitJson(['popup' => 'Сохранен', 'id' => $id]);
			} elseif (is_bool($id)) {
				$this->exitWithPopup('Сохранено');
			} else {
				$this->exitWithError('Ответ не сохранен');
			}
		}
	}

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
