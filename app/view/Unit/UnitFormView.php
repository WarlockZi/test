<?php


namespace app\view\Unit;


use app\model\Unit;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use Illuminate\Database\Eloquent\Collection;

class UnitFormView
{

   public static function edit($unit): string
   {
      $list = self::morphs($unit->units);

      return
         MorphBuilder::build($unit, 'units', 'multi')
            ->html($list)
            ->get();
   }


   public static function selector($excluded = 0, $selected = 0): string
   {
      $selector = SelectBuilder::build(
         ArrayOptionsBuilder::build(Unit::all())
            ->initialOption()
            ->selected($selected)
            ->excluded($excluded)
            ->get()
      )->get();

      return $selector;
   }

   public static function selectorNew(Unit $unit): string
   {
      $units    = $unit->pivot->is_base ? new Collection([$unit]) : Unit::all();
      $selector = SelectNewBuilder::build(
         ArrayOptionsBuilder::build($units)
            ->initialOption()
            ->selected($unit->id)
            ->get()
      )
         ->class('name')
         ->get();
      return $selector;
   }

   public static function noneSelector(Unit $baseUnit): string
   {
      $units    = Unit::all();
      $selector = SelectNewBuilder::build(
         ArrayOptionsBuilder::build($units)
            ->initialOption()
            ->excluded($baseUnit->id)
            ->get()
      )
         ->class('name')
         ->get();

      return $selector;
   }

   protected static function morphs($items)
   {
      $list =
         CustomList::build(Unit::class)
            ->pageTitle('Единицы измерения')
            ->addButton('ajax')
            ->items($items)
            ->column(
               ListColumnBuilder::build('id')
                  ->width('50px')
                  ->get()
            )
            ->column(
               ListColumnBuilder::build('коэфф')
                  ->width('50px')
                  ->function(Unit::class, 'multiplier')
                  ->get()
            )
            ->column(
               ListColumnBuilder::build('name')
                  ->name('Краткое')
                  ->contenteditable()
                  ->get()
            )
            ->column(
               ListColumnBuilder::build('full_name')
                  ->contenteditable()
                  ->name('Полное')
                  ->get()
            )
            ->column(
               ListColumnBuilder::build('code')
                  ->contenteditable()
                  ->name('Код')
                  ->get()
            )
            ->del()
            ->get();
      return $list;
   }

   public static function editItem($unit): string
   {
      $item =
         ItemBuilder::build($unit, 'unit')
            ->pageTitle('Единицы измерения')
            ->field(
               ItemFieldBuilder::build('id', $unit)
                  ->get()
            )
            ->field(
               ItemFieldBuilder::build('name', $unit)
                  ->contenteditable()
                  ->get()
            )
            ->del()
            ->get();
      return $item;
   }

   public static function index(): string
   {
      return CustomList::build(Unit::class)
         ->pageTitle('Единицы измерения')
         ->addButton('ajax')
         ->items(Unit::all())
         ->column(
            ListColumnBuilder::build('id')
               ->width('50px')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('name')
               ->name('Краткое')
               ->contenteditable()
               ->get()
         )
         ->column(
            ListColumnBuilder::build('full_name')
               ->contenteditable()
               ->name('Полное')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('code')
               ->contenteditable()
               ->name('Код')
               ->get()
         )
         ->del()
         ->get();
   }

}