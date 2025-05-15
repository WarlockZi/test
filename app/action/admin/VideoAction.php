<?php

namespace app\action\admin;


use app\model\Post;
use app\model\Videoinstruction;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Spatie\Sitemap\Tags\Video;

class VideoAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        $videos = Videoinstruction::where('id', '>', 0)
            ->orderBy('tag')
            ->orderBy('sort')
            ->get();
        return Table::build($videos)
            ->column(
                ColumnBuilder::build('sort')
                    ->name('№')
                    ->width('50px')
                    ->sort()
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Название')
                    ->width('auto')
                    ->contenteditable()
                    ->get()

            )
            ->column(
                ColumnBuilder::build('link')
                    ->name('Ссылка')
                    ->contenteditable()
                    ->width('auto')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('tag')
                    ->name('Группа')
                    ->contenteditable()
                    ->width('auto')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('user_id')
                    ->width('50px')
                    ->name('Польз')
                    ->get()
            )
            ->del()
            ->addButton()
            ->get();
    }
}