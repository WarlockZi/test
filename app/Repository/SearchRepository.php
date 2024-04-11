<?php


namespace app\Repository;


use app\model\Product;

/**
 * @method static index()
 */
class SearchRepository
{
	public function getQuery($admin)
	{
		$query = Product::query();
		if ($admin) {
			$query->withTrashed();
			$query->select('name', 'slug', 'art', 'id', 'instore', 'deleted_at');
			return $query;
		}
		return $query->select('name', 'slug', 'art', 'id', 'instore',);
	}

	public function getArtQuery($query,$queryString)
	{
		return 		$query
			->where('art', 'LIKE', $queryString)
			->where('instore', '>', 0)
			->take(20)
			->get()
			->toArray();

	}

	public function getNameQuery($query,$queryString)
	{
		return 		$query
			->where('name', 'LIKE', $queryString)
			->where('instore', '>', 0)
			->take(20)
			->get()
			->toArray();
	}

	public function getSIdQuery($query,$queryString)
	{
		return 		$query
			->where('1s_id', 'LIKE', $queryString)
//			->where('instore', '>', 0)
			->take(20)
			->get()
			->toArray();
	}

}