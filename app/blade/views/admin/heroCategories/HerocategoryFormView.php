<?php

namespace app\blade\views\admin\heroCategories;

use app\model\Category;
use app\model\Unit;
use app\repository\HeroCategroyRepository;
use app\view\Category\CategoryFormView;
use app\view\components\Builders\SelectBuilder\optionBuilders\PluckOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class HerocategoryFormView
{

    public static function admin(): array
    {
        $heroCategories = HeroCategroyRepository::hero();
        return Table::build($heroCategories)
            ->data(['model' => 'Herocategory',
            ])
            ->column(ColumnBuilder::build('title')
                ->data(['field' => 'title'])
                ->headerTitle('Заголовок')
                ->contenteditable()
                ->get()
            )
            ->column(ColumnBuilder::build('img')
                ->callback(function ($heroCategory) {
                    return $heroCategory->img;
                })
                ->data(['field' => 'img'])
                ->headerTitle('Картинка')
                ->contenteditable()
                ->get()
            )
            ->column(ColumnBuilder::build('subtitle')
                ->data(['field' => 'subtitle'])
                ->headerTitle('Подзаголовок')
                ->contenteditable()
                ->get()
            )
            ->column(ColumnBuilder::build('name')
                ->callback(function ($heroCategory) {
                    return SelectBuilder::build(
                        PluckOptionsBuilder::build(Category::pluck('name', 's_id'))
                            ->initialOption()
                            ->selected($heroCategory->category_1s_id)
                            ->get())
                        ->field('category_1s_id')
                        ->get();
                })
                ->emptyRow(function () {
                    return SelectBuilder::build(
                        PluckOptionsBuilder::build(Category::pluck('name', 's_id'))
                            ->initialOption()
                            ->get())
                        ->field('category_1s_id')
                        ->removeSelectNewAttr()
                        ->get();
                })
                ->data(['field' => 'category_1s_id',
                    ])
                ->headerTitle('Категория')
                ->contenteditable()
                ->get()
            )
            ->addButton()
            ->get();
    }
}