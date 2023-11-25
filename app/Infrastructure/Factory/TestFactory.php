<?php


namespace app\Factory;


use app\Services\Test\TestDoService;
use app\Services\Test\TestEditService;

class TestFactory extends AbstractTestFactory
{
	public function do($id)
	{
		return new TestDoService($id);
	}

	public function edit($id)
	{
		return new TestEditService($id);
	}

}