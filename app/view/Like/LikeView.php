<?php

namespace app\view\Like;

use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;

class LikeView
{
    public static function all(Collection|array $likes)
    {
        if (!$likes) return [];

        return Table::build($likes)
            ->model('like')
            ->class('likes')
//            ->pageTitle('Понравившиеся товары')
            ->column(
                ColumnBuilder::build('Название')
                    ->callback(function ($product) {
                        return $product['print_name'];
                    })
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Картинка')
                    ->class('img')
                    ->callback(function ($product) {
                        return "<img src='{$product['mainImage']}'>";
                    })
                    ->get()
            )
            ->del()
            ->get();
    }
}