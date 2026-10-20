<?php

namespace app\action\admin;


use app\model\Role;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class RoleAction implements IShowTable
{
    public function __construct()
    {
    }

    public function table(): array
    {
        return Table::build(Role::all())
            ->pageTitle('Роли')
            ->column(
                ColumnBuilder::build('id')
                    ->headerTitle('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->headerTitle('Роль')
                    ->headerSearch()()
                    ->contenteditable()
                    ->headerSort()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('description')
                    ->headerTitle('Описание')
                    ->contenteditable(true)
                    ->headerSearch()(true)
                    ->width('1fr')
                    ->get()
            )
            ->addButton()
            ->model('role')
            ->del()
            ->get();
    }

}