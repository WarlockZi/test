<?php


namespace app\Factory;


abstract class AbstractTestFactory
{
	public static function getFactory(string $type)
	{
		if ($type === 'test') {
			return new TestFactory();
		} elseif ($type === 'opentest') {
			return new OpentestFactory();
		}
	}

	abstract public function do(int $id);
	abstract public function edit(int $id);

}