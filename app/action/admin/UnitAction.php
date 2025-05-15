<?php

namespace app\action\admin;


use app\model\Unit;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class UnitAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Unit::all())
            ->pageTitle('Единицы измерения')
            ->addButton()
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