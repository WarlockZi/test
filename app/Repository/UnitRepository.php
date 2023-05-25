<?php


namespace app\Repository;


use app\model\Test;

use app\model\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository
{


	public static function edit(int $id)
	{
		return Unit::with('units')
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
}