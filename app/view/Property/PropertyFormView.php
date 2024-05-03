<?php


namespace app\view\Property;


use app\model\Category;
use app\model\Property;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class PropertyFormView
{
    public static function usedParentsProps(Category $category): array
    {
        $propIds = [];
        $parent  = $category->parentRecursive;
        if ($parent) {
            if ($parent->properties->count()) {
                foreach ($parent->properties as $prop) {
                    $propIds[] = $prop->id;
                }
            }
        }
        return $propIds;
    }

    public static function usedCatNParentProps(Category $category): array
    {
        $propIds = [];
        if ($category->properties->count()) {
            foreach ($category->properties as $prop) {
                $propIds[] = $prop->id;
            }
        }

        return array_merge($propIds, self::usedParentsProps($category));
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