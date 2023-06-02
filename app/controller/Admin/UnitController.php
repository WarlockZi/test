<?php


namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Product;
use app\model\Unit;
use app\Repository\UnitRepository;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\FormViews\UnitFormView;

class UnitController extends AppController
{
	public $model = Unit::class;

	public function actionIndex()
	{
		$units = UnitFormView::index();
		$this->set(compact('units'));
	}

	public function actionAttachUnit()
	{
		$req = $this->isAjax();
		$pivot = $req['pivot'];
		$product = Product::with('baseUnit')->find($req['productId']);
		if (!$pivot['unitId']) $this->exitWithError('No pivot unitId');
		$baseUnit = $product->baseUnit;
		if (!$baseUnit) $this->exitWithError('No base unit');

		$unit = Unit::find($pivot['unitId']);

		$product->baseUnit->units()->sync([$unit->id=>[
			'multiplier'=>$pivot['multiplier'],
			'product_id'=>$product->id
		]]);


		if ($req){

		}

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
}