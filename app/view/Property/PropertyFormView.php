<?php


namespace app\view\Property;


use app\model\Category;
use app\model\Property;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class PropertyFormView
{
  public static function usedParentsProps(Category $c):array
  {
    $propIds = [];
    $parent = $c->parentRecursive;
    if ($parent) {
      if ($parent->properties->count()) {
        foreach ($parent->properties as $prop) {
          $propIds[] = $prop->id;
        }
      }
    }
    return $propIds;
  }
	public static function usedCatNParentProps(Category $c):array
	{
		$propIds = [];
    if ($c->properties->count()) {
      foreach ($c->properties as $prop) {
        $propIds[] = $prop->id;
      }
    }

		return array_merge( ...$propIds, ...self::usedParentsProps($c));
	}

	public static function newPropertySelector($c)
	{
		$excluded = self::usedCatNParentProps($c);
		return SelectBuilder::build(
			ArrayOptionsBuilder::build(Property::all())
				->excluded($excluded)
				->selected(0)
				->initialOption()
				->get()
		)->get();

	}

	public static function selector(Category $c, Property $p)
	{
	  $excluded = self::usedParentsProps($c);
		return SelectBuilder::build(
			ArrayOptionsBuilder::build(Property::all())
				->excluded($excluded)
				->selected($p->id)
				->initialOption()
				->get()
		)->get();

	}

	public function __construct()
	{

	}


}