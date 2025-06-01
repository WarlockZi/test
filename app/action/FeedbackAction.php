<?php

namespace app\action;

use app\action\admin\IShowTable;
use app\model\Feedback;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class FeedbackAction implements IShowTable
{
    public function table():array
    {
        return Table::build(Feedback::all())
            ->model('feedback')
            ->pageTitle('Сообщения пользователей')
            ->column(
                ColumnBuilder::build('name')
                    ->name('Имя')
                    ->search()
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
                    ->sort()
                    ->search()
                    ->name('email')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('phone')
                    ->sort()
                    ->search()
                    ->name('Телефон')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
                    ->sort()
                    ->name('Телефон')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('message')
                    ->name('Сообщение')
                    ->get()
            )
            ->column(ColumnBuilder::build('done')
                ->name('Обработан')
                ->callback(function ($item) {
                    return CheckboxBuilder::build()
                        ->field('done')
                        ->checked($item->done)
                        ->get();
                })
                ->get()

            )
            ->get();
    }
}