<?php

namespace app\action;



use app\model\Feedback;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
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
                    ->headerSearch()
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
//                    ->name('Имя')
                    ->headerSearch()
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
//                    ->name('email')
                    ->headerSort()
                    ->headerSearch()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('phone')
//                    ->name('Телефон')
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('message')
//                    ->name('Сообщение')
                    ->get()
            )
            ->column(ColumnBuilder::build('done')
//                ->name('Обработан')
                ->callback(function ($unit) {
                    return CheckboxBuilder::build()
                        ->checked($unit->done)
//                        ->data(['field'=>'show_front'])
                        ->get()->toHtml();
                })
//                ->component(
//                    (new FeedbackCheckboxBuilder)
//                        ->setCheckedFn(
//                            function ($item) {
//                                return boolval($item->done);
//                            }
//                        )
//                        ->setDataField('done')
//                        ->get()
//                )
                ->get()
            )
            ->get();
    }
    public function UndoneTable(): array
    {
        return Table::build(Feedback::whereNull('done')->get())

            ->model('feedback')
            ->pageTitle('Необработанные сообщения пользователей')
            ->column(
                ColumnBuilder::build('создан')
                    ->callback(function ($feedback) {
                        return $feedback->created_at;
                    })
                    ->width('100px')
                    ->headerSearch()
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('имя')
                    ->callback(function ($feedback) {
                        return $feedback->name;
                    })
                    ->headerSearch()
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('email')
                    ->callback(function ($feedback) {
                        return $feedback->email;
                    })
                    ->headerSort()
                    ->headerSearch()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Телефон')
                    ->callback(function ($feedback) {
                        return $feedback->phone;
                    })
                    ->headerSort()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Сообщение')
                    ->callback(function ($feedback) {
                        return $feedback->message;
                    })
                    ->get()
            )
            ->column(ColumnBuilder::build('Обработан')
//                ->name('Обработан')
                ->callback(function ($unit) {
                    return CheckboxBuilder::build()
                        ->checked($unit->done)
//                        ->data(['field'=>'show_front'])
                        ->get()->toHtml();
                })
//                ->component(
//                    (new FeedbackCheckboxBuilder)
//                        ->setCheckedFn(
//                            function ($item) {
//                                return boolval($item->done);
//                            }
//                        )
//                        ->setDataField('done')
//                        ->get()
//                )
                ->get()
            )
            ->get();
    }

}