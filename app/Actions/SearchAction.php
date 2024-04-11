<?php


namespace app\Actions;

use app\Repository\SearchRepository;

class SearchAction
{
	protected $repository;

	public function __construct()
	{
		$this->repository = new SearchRepository();
	}

	public function prepareQuryString($query): string
	{
		return '%' . stripslashes(mb_strtolower(trim($query))) . '%';
	}

	public function index(string $text)
	{
		$queryString = $this->prepareQuryString($text);

		$admin = in_array('/adminsc', parse_url($_SERVER['HTTP_REFERER']));

		$art = $this->repository->getArtQuery($this->repository->getQuery($admin), $queryString);
		$name = $this->repository->getNameQuery($this->repository->getQuery($admin), $queryString);
		$sId = $this->repository->getSIdQuery($this->repository->getQuery($admin), $queryString);

		return array_merge($art, $name, $sId);
	}
}