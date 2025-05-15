<?php

namespace app\action\admin;


use app\model\Property;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class PropertyAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Property::all())
            ->model('property')
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->name('Id')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->name('Название')
                    ->search()
                    ->sort()
                    ->contenteditable()
                    ->get()
            )->column(
                ColumnBuilder::build('show_as')
                    ->contenteditable()
                    ->name('Показывать как')
                    ->get()
            )
            ->edit()
            ->del()
            ->addButton()
            ->get();
    }

}