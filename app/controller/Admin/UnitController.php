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

  protected function check($req):array
  {
    $pivot = $req['pivot'];
    if (!$pivot['unitId']) $this->exitWithError('No pivot unitId');

    $product = Product::with('baseUnit')->find($req['productId']);
    if (!$product->baseUnit) $this->exitWithError('No base unit');
    $unit = Unit::find($pivot['unitId']);
    $arr = array($pivot, $product, $unit);
    $b = $product->baseUnit->toArray();
    $u = $unit->toArray();
    $dd = $product->baseUnit->units()->find(2);
    return $arr;
  }

  public function actionAttachUnit()
  {
    list($pivot, $product, $unit) = $this->check($this->isAjax());
    $product->baseUnit->units()->attach(
      $unit, ['multiplier' => $pivot['multiplier']]
    );
  }
  public function actionUpdateUnit()
  {
    list($pivot, $product, $unit) = $this->check($this->isAjax());
    $product->baseUnit->units()->updateExistingPivot(
      $unit, ['multiplier' => $pivot['multiplier']]
    );
  }



  public function actionDetachUnit()
  {
    $req = $this->ajax;
    $productId = $req['productId'];
    $baseUnit = Unit::find($req['baseUnit'])
      ->units()
      ->detach($req['unit']);

    exit(json_encode(['poppup' => 'ошибка']));

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