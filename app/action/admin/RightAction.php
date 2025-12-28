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
            ->data(['model'=>'right'])
            ->column(
                ColumnBuilder::build('ID')
                    ->callback(function ($right){
                        return $right->id;
                    })
                    ->emptyRow(0)
                    ->get())
            ->column(
                ColumnBuilder::build('Право')
                    ->data(['field'=>'name'])
                    ->callback(function($right){
                        return $right->name;
                    })
                    ->emptyRow('')
                    ->search()
                    ->contenteditable()
                    ->sort()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('Описание')
                    ->callback(function($right){
                        return $right->description;
                    })
                    ->data(['field'=>'description'])
                    ->emptyRow('')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->addButton()
            ->del()
            ->get();
    }

}