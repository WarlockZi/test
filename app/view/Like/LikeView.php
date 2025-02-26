<?php

namespace app\view\Like;

use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;

class LikeView
{
    public static function all(Collection $likes)
    {
        return Table::build($likes)
            ->model('like')
            ->class('likes')
            ->pageTitle('Понравившиеся товары')
            ->column(
                ColumnBuilder::build('product')
                    ->name('Название')
                    ->callback(function ($like){
                        return $like->product->print_name;
                    })
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Картинка')
                    ->name('Картинка')
                    ->class('img')
                    ->callback(function ($like){
                        return "<img src='{$like->product->mainImage}'>";
                    })
                    ->get()
            )
            ->del()

            ->get();

    }

}