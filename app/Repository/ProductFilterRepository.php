<?php


namespace app\Repository;

use app\model\Product;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Builder;

class ProductFilterRepository
{
	protected Builder $query;
	protected  $builder;
	protected  array $req;

	public static function make(array $req): ProductFilterRepository
	{
		$self = new self();
		$self->req = $req;
		$self->query = Product::query();
		$self->query = $self->query->withMainImages();
		$self->builder = DB::table('products');
		return $self;
	}

	public function where($column,$operator,$value)
	{
		$this->builder->where($column,$operator,$value);
		return $this;
	}

	public function get(): array
	{
		return $this->query->take(10)->get('name')->toArray();
	}


}