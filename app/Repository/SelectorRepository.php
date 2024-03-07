<?php


namespace app\Repository;


use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;

class SelectorRepository
{
	public static function userManager($userManager)
	{
		return SelectNewBuilder::build(
			ArrayOptionsBuilder::build($userManager)
				->initialOption()
				->get()
		)
			->get();
	}
}