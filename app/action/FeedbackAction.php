<?php

namespace app\action;



use app\model\Feedback;
use app\view\components\Builders\CheckboxBuilder\FeedbackCheckboxBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class FeedbackAction
{
    public function DoneTable(): array
    {
        return Table::build(Feedback::where('done', 1)->get())
//        return Table::build(Feedback::take(3)->get())
            ->model('feedback')
            ->pageTitle('Обработанные сообщения пользователей')
            ->column(
                ColumnBuilder::build('created_at')
//                    ->name('создан')
                    ->width('100px')
                    ->search()
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
//                    ->name('Имя')
                    ->search()
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
//                    ->name('email')
                    ->sort()
                    ->search()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('phone')
//                    ->name('Телефон')
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('message')
//                    ->name('Сообщение')
                    ->get()
            )
            ->column(ColumnBuilder::build('done')
//                ->name('Обработан')
                ->component(
                    (new FeedbackCheckboxBuilder)
                        ->setCheckedFn(
                            function ($item) {
                                return boolval($item->done);
                            }
                        )
                        ->setDataField('done')
                        ->get()
                )
                ->get()
            )
            ->get();
    }
    public function UndoneTable(): array
    {
        return Table::build(Feedback::where('done', 0)->get())
//        return Table::build(Feedback::take(3)->get())
            ->model('feedback')
            ->pageTitle('Необработанные сообщения пользователей')
            ->column(
                ColumnBuilder::build('created_at')
//                    ->name('создан')
                    ->width('100px')
                    ->search()
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
//                    ->name('Имя')
                    ->search()
                    ->sort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
                    ->sort()
                    ->search()
//                    ->name('email')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('phone')
                    ->sort()
//                    ->name('Телефон')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('message')
//                    ->name('Сообщение')
                    ->get()
            )
            ->column(ColumnBuilder::build('done')
//                ->name('Обработан')
                ->component(
                    (new FeedbackCheckboxBuilder)
                        ->setCheckedFn(
                            function ($item) {
                                return boolval($item->done);
                            }
                        )
                        ->setDataField('done')
                        ->get()
                )
                ->get()
            )
            ->get();
    }

}