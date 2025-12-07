<?php

namespace app\action\admin;


use app\model\Unit;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class UnitAction implements IShowTable
{
    public function __construct()
    {
    }

    public function table(): array
    {
        return Table::build(Unit::all())
            ->pageTitle('Единицы измерения')
            ->data(['model' => 'unit'])
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Краткое')
                    ->callback(function ($unit) {
                        return $unit->name;
                    })
                    ->data(['field' => 'name'])
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Полное')
                    ->callback(function ($unit) {
                        return $unit->full_name;
                    })
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Код')
                    ->contenteditable()
                    ->callback(function ($unit) {
                        return $unit->code;
                    })
                    ->get()
            )
            ->addButton()
            ->del()
            ->get();
    }

}