<?php


namespace app\controller\Admin;


use app\Actions\UnitAction;
use app\controller\AppController;
use app\model\Unit;
use app\Repository\UnitRepository;
use app\view\Unit\UnitFormView;


class UnitController extends AppController
{
   private UnitRepository $repo;

   public function __construct()
   {
      $this->repo = new UnitRepository();
   }

   public static function attachUnit(array $req)
   {
      list($pivot, $baseUnit, $old_id, $new_id) = $req;
      $res = $baseUnit->units()
         ->attach(
            $new_id, [
               'multiplier' => $pivot['multiplier'],
               'product_id' => $pivot['product_id']]
         );
      return true;
   }

   public static function detachUnit(array $req)
   {
      list($pivot, $baseUnit, $old_id, $new_id) = $req;

      if ($baseUnit->units()
         ->wherePivot('product_id', $pivot['product_id'])
         ->detach($old_id)
      ) return true;
      return false;
   }

   public function actionAttachUnit()
   {
      $this->repo->attachUnit($this->ajax);
   }

   public function actionChangeUnit()
   {
      $this->repo->changeUnit($this->ajax);
   }

   public function actionDetachUnit()
   {
      $this->repo->detachUnit($this->ajax);
   }

   public function actionEdit()
   {
      $id = $this->getRoute()->id;
      if ($id) {
         $unit     = UnitRepository::edit($id);
         $unitItem = UnitFormView::editItem($unit);
         $this->set(compact('unit', 'unitItem'));
      }
   }

   public function actionIndex(): void
   {
      $units = UnitFormView::index();
      $this->set(compact('units'));
   }

}