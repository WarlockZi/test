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
                    ->headerTitle('№')
                    ->width('50px')
                    ->headerSort()
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->headerTitle('Название')
                    ->width('auto')
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('link')
                    ->headerTitle('Ссылка')
                    ->contenteditable()
                    ->width('auto')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('tag')
                    ->headerTitle('Группа')
                    ->contenteditable()
                    ->width('auto')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('user_id')
                    ->width('50px')
                    ->headerTitle('Польз')
                    ->get()
            )
            ->del()
            ->addButton()
            ->get();
    }
}