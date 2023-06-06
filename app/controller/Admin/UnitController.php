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

	protected function check($req): array
	{
		$pivot = $req['pivot'];
		if (!$req['unitId']) $this->exitWithError('No pivot unitId');

		$product = Product::with('baseUnit.units')
      ->where('1s_id',$req['pivot']['product_id'])
      ->first();
		if (!$product->baseUnit) $this->exitWithError('No base unit');
		$unit = Unit::find($req['unitId']);
	$arr = array($pivot, $product, $unit);
		return $arr;
	}

	public function actionAttachUnit()
	{
		list($pivot, $product, $unit) = $this->check($this->ajax);
		$product->baseUnit->units()->attach(
			$unit, ['multiplier' => $pivot['multiplier']]
		);
	}

	public function actionUpdatePivot()
	{
		list($pivot, $product, $unit) = $this->check($this->ajax);
		$product->baseUnit->units()->updateExistingPivot(
			$unit,['multiplier' => $pivot['multiplier'],
				'product_id' => $pivot['product_id']]
    );
	}

	public function actionChangeUnit()
	{
		$req = $this->ajax;

		$prev = $req['prev'];
		$next = $req['next'];
		$baseUnit = $req['baseUnit'];
		$pivot = $req['pivot'];

		Unit::find($baseUnit)
			->units()
			->detach($prev);
		$res = Unit::find($baseUnit)
			->units()
			->attach([$next=>['multiplier' => $pivot['multiplier'],
				'product_id' => $pivot['product_id']]]);
		$this->exitWithPopup('Ok');
	}

	public function actionDetachUnit()
	{
		$req = $this->ajax;

		Unit::find($req['baseUnit'])
			->units()
			->detach($req['unitId']);

		$this->exitJson(['ok'=>'ok','popup'=>'Отсоединен']);

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