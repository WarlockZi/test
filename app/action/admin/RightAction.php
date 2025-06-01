<?php

namespace app\action\admin;


use app\model\Right;
use app\model\Role;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class RightAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Right::all())
            ->pageTitle('Права')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->name('Право')
                    ->search()
                    ->contenteditable()
                    ->sort()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('description')
                    ->name('Описание')
                    ->contenteditable(true)
                    ->search(true)
                    ->width('1fr')
                    ->get()
            )
            ->addButton()
            ->model('right')
            ->del()
            ->get();
    }

}