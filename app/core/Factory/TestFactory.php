<?php


namespace app\core\Factory;


use app\core\Factory\AbstractTestFactory;
use app\Services\Test\TestDoService;
use app\Services\Test\TestEditService;

class TestFactory extends AbstractTestFactory
{
	public function do($id):TestDoService
	{
		return new TestDoService($id);
	}

	public function edit($id):TestEditService
	{
		return new TestEditService($id);
	}

}