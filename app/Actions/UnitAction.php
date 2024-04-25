<?php


namespace app\Actions;


use app\model\Unit;

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
//        $id = $req['s_id'];
//        $unitId = $req['unit_id'];
        $pId = '1d7ddc15-4b51-11ec-8219-0cc47a6d1d83';
        $units = Unit::findOrFail($pId)->dopUnits;




		$pivot = $req;
//		$pivot = $req['pivot'];
//		$baseUunit = Unit::find($req['baseUnitId']);
//		$old_id = $req['morphed']['old_id'];
//		$new_id = $req['morphed']['new_id'];
//		$arr = array($pivot, $baseUunit, $old_id, $new_id);
//
//		$detach = $req['morphed']['detach'];
//		if (!$old_id) {
//			$res = self::attachUnit($arr);
//		} elseif ($detach) {
//			$res = self::detachUnit($arr);
//		} elseif ($old_id === $new_id) {
//			$res = self::updatePivot($arr);
//		} elseif ($old_id !== $new_id) {
//			$res = self::swapUnit($arr);
//		}
//
//		if ($res)
//			exit(json_encode(['arr' => ['ok' => 'ok', 'popup' => 'Успешно']]));
//		exit(json_encode(['error' => 'error', 'popup' => 'Что-то пошло не так']));

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