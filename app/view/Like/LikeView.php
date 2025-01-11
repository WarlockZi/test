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
            ->class('likes')
            ->pageTitle('Понравившиеся товары')
            ->column(
                ColumnBuilder::build()
                    ->name('id')
                    ->get()
            )
            ->get();

    }

}