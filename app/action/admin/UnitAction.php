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
                    ->emptyRow('0')
                    ->data(['field' => 'id'])
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Краткое')
                    ->callback(function ($unit) {
                        return $unit->name;
                    })
                    ->emptyRow('')
                    ->data(['field' => 'name'])
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Полное')
                    ->callback(function ($unit) {
                        return $unit->full_name;
                    })
                    ->data(['field' => 'full_name'])
                    ->emptyRow('')
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Код')
                    ->data(['field' => 'code'])
                    ->emptyRow('')
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