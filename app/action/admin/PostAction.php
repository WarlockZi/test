<?php

namespace app\action\admin;


use app\model\Post;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class PostAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(
            Post::with('chief')->get()
        )
            ->pageTitle('Должности')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Краткое наим')
                    ->contenteditable()
                    ->class('left')
                    ->width('100px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('full_name')
                    ->name('Полное наим')
                    ->contenteditable()
                    ->class('left')
                    ->width('250px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('chief')
                    ->callback(fn($post) => $post->chief->name ?? '')
                    ->class('left')
                    ->name('Подчиняется')
                    ->width('1fr')
                    ->get()
            )
            ->edit()
            ->del()
            ->addButton()
            ->get();
    }
}