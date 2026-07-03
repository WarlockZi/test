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
//            ->model('property')
            ->data(['model'=>'property'])
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->get())
            ->column(
                ColumnBuilder::build('Название')
                    ->callback(function ($prop){
                        return $prop->name;
                    })
                    ->headerSearch()
                    ->headerSort()
                    ->contenteditable()
                    ->get()
            )->column(
                ColumnBuilder::build('Показывать как')
                    ->contenteditable()
                    ->callback(function ($prop){
                        return $prop->show_as;
                    })
                    ->get()
            )
            ->edit()
            ->del()
            ->addButton()
            ->get();
    }

}