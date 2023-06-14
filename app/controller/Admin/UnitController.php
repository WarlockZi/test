<?php


namespace app\controller\Admin;


use app\Actions\UnitAction;
use app\controller\AppController;
use app\model\Unit;
use app\Repository\UnitRepository;
use app\view\FormViews\UnitFormView;

class UnitController extends AppController
{
	public $model = Unit::class;

	public function actionAttachUnit()
	{
		UnitAction::attachUnit($this->ajax);
	}

	public function actionUpdatePivot()
	{
//		UnitAction::updatePivot($this->ajax);
	}

	public function actionChangeUnit()
	{
		UnitAction::changeUnit($this->ajax);
	}

	public function actionDetachUnit()
	{
		UnitAction::detachUnit($this->ajax);
	}

	public function actionEdit()
	{
		$id = $this->getRoute()->id;
		if ($id) {
			$unit = UnitRepository::edit($id);
			$unitItem = UnitFormView::editItem($unit);
			$this->set(compact('unit', 'unitItem'));
		}
	}

	public function actionIndex()
	{
		$units = UnitFormView::index();
		$this->set(compact('units'));
	}

}