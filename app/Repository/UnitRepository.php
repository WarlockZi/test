<?php


namespace app\Repository;


use app\model\Test;

use app\model\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository
{

	public static function edit(int $id)
	{
		return Unit::query()
//			->with('units')
			->where('id', $id)
			->first();
	}

	public static function editList($id)
	{
		return Unit::query()
			->where('id', $id)
			->with('units')
			->get();
	}

	public static function index(): Collection
	{
		return Test::query()
			->where('test_id', 0)
			->with('children')
			->select('id', 'name')
			->get();
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
}