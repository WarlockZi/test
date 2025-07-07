<?php

namespace app\action\admin;


use app\model\Role;
use app\model\Unit;
use app\model\UserYandex;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class UserYandexAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(UserYandex::with('role')->get())
            ->pageTitle('Пользователи Yandex')
            ->model('userYandex')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('last_name')
                    ->name('Фамилия')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('first_name')
                    ->name('Имя')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('default_email')
                    ->name('email')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('default_phone')
                    ->name('phone')
                    ->callback(function ($userY) {
                        $obj = json_decode($userY->default_phone);
                        return $obj->number;
                    })
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('role')
                    ->name('роль')
                    ->width('1fr')
                    ->callback(function ($user) {
                        return self::roleSelector($user);
                    })
                    ->get())
            ->edit()
            ->del()
            ->get();
    }
    protected static function roleSelector(UserYandex $user): string
    {
        $selected = $user->role->first()->id ?? 0;
        return SelectBuilder::build(
            ArrayOptionsBuilder::build(Role::all())
                ->initialOption()
                ->selected($selected)
                ->get())
            ->relation('role', 'roleUserYandex')
            ->get();
    }
}