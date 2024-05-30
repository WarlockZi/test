<?php


namespace app\Actions;


use app\core\Response;
use app\model\ProductUnit;


class UnitAction
{
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

   public static function swapUnit(array $req)
   {
      self::detachUnit($req);
      self::attachUnit($req);
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

   public static function changeUnit(array $req)
   {
      $productId   = $req['pivot']['product_id'];
      $unitId      = $req['morphed']['new_id'];
      $productUnit = [
         'unit_id' => $unitId,
         'multiplier' => $req['pivot']['multiplier'],
         'is_shippable' => $req['pivot']['is_shippable'],
      ];

      try {
         $unit = ProductUnit::query()
            ->updateOrCreate(
               ['product_1s_id'=> $productId,
                  'unit_id'=> $unitId],
               $productUnit);
         Response::exitWithPopup('изменено');
      } catch (\Throwable $exception) {
         Response::exitWithPopup('не изменено');
      }
   }

   protected static function updatePivot(array $req)
   {
      list($pivot, $baseUnit, $old_id, $new_id) = $req;
      $res = $baseUnit->units()
         ->wherePivot('product_id', $pivot['product_id'])
         ->updateExistingPivot($old_id,
            ['multiplier' => $pivot['multiplier'],
               'main' => $pivot['main']]);
      if ($res)
         return true;
      return false;
   }
}