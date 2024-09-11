<?php


namespace app\view\Unit;


use app\model\Unit;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
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


    protected static function morphs($items)
    {
        $list =
            Table::build(Unit::class)
                ->pageTitle('Единицы измерения')
                ->addButton('ajax')
                ->items($items)
                ->column(
                    ColumnBuilder::build('id')
                        ->width('50px')
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('коэфф')
                        ->width('50px')
                        ->function(Unit::class, 'multiplier')
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('name')
                        ->name('Краткое')
                        ->contenteditable()
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('full_name')
                        ->contenteditable()
                        ->name('Полное')
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('code')
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
        return Table::build(Unit::class)
            ->pageTitle('Единицы измерения')
            ->addButton('ajax')
            ->items(Unit::all())
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Краткое')
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('full_name')
                    ->contenteditable()
                    ->name('Полное')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('code')
                    ->contenteditable()
                    ->name('Код')
                    ->get()
            )
            ->del()
            ->get();
    }

}