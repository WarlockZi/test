<?php


namespace app\Repository;


use app\model\Test;
use Illuminate\Database\Eloquent\Model;

class TestRepository
{
	protected $test;
	protected $questions;
	protected $page_name;
	protected $pagination;


	public static function do(int $id):Model
	{
			return Test::query()
				->with('questions.answers')
				->find($id);
	}

	public static function edit(int $id):Model
	{
			return Test::with('questions.answers')
				->orderBy('sort')
				->find($id);
	}

	public function getTest()
	{
		return $this->test;
	}

	public function setTest($test)
	{
		$this->test = $test;
		return $this;
	}

	public function getQuestions()
	{
		return $this->questions;
	}

	public function setQuestions($questions)
	{
		$this->questions = $questions;
		return $this;
	}

	public function getPageName()
	{
		return $this->page_name;
	}

	public function setPageName($page_name)
	{
		$this->page_name = $page_name;
		return $this;
	}

	public function getPagination()
	{
		return $this->pagination;
	}

	public function setPagination($pagination)
	{
		$this->pagination = $pagination;
		return $this;
	}


}