<?php


namespace app\view\Property;


use app\model\Category;
use app\model\Property;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class PropertyFormView
{
	public static function usedPropsArr(Category $c):array
	{
		$C = $c->toArray();
		$propIds = [];
		$parent = $c->parentRecursive;
//		$P = $parent->toArray();
		if ($parent) {
			if ($parent->properties->count()) {
				foreach ($parent->properties as $prop) {
					$propIds[] = $prop->id;
				}
			}
		}
		return $propIds;
	}

	public static function newPropertySelector($excluded = [], $selected = 0)
	{
//		$used = self::usedPropsArr($category);
		return SelectBuilder::build(
			ArrayOptionsBuilder::build(Property::all())
				->excluded($excluded)
				->selected($selected)
				->initialOption()
				->get()
		)->get();

	}

	public static function selector($excluded, $selected)
	{
		return SelectBuilder::build(
			ArrayOptionsBuilder::build(Property::all())
				->excluded($excluded)
				->selected($selected)
				->initialOption()
				->get()
		)->get();

	}

	public function __construct()
	{

	}


}