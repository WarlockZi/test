<?php

namespace app\action\admin;


use app\model\Role;
use app\model\Tag;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class RoleAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Role::all())
            ->pageTitle('Роли')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->name('Роль')
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
            ->model('role')
            ->del()
            ->get();
    }

}