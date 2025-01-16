<?php


namespace app\view\Promotion;


use app\core\FS;
use app\model\Promotion;
use app\model\Unit;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;

class PromotionFormView
{

    static function edit($promotion): string
    {
        $link      = $promotion->product ? "adminsc/product/edit/{$promotion->product->id}" : 'adminsc/product/table';
        $promotion = ItemBuilder::build($promotion, 'promotion')
            ->field(
                ItemFieldBuilder::build('id', $promotion)
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('count', $promotion)
                    ->name('количество')
                    ->contenteditable()
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('unit', $promotion)
                    ->html(self::unitSelector($promotion->unit_id))
                    ->name('Единица')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('new_price', $promotion)
                    ->contenteditable()
                    ->name('новая цена')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('active_till', $promotion)
                    ->html(FS::getFileContent(__DIR__ . '/Admin/active_till.php', compact('promotion')))
                    ->name('Действует до')
                    ->get()
            )
            ->toList($link, 'К товару')
            ->pageTitle('Акция')
            ->get();

        return $promotion;
    }

    protected static function unitSelector($selected): string
    {
        $s = SelectBuilder::build(
            ArrayOptionsBuilder::build(Unit::all())
                ->selected($selected ?? 0)
                ->initialOption()
                ->get()
        )
            ->class('unit')
            ->get();
        return $s;
    }

    public static function adminIndex(Collection $promotions): string
    {
        $promotion = Table::build($promotions)
            ->pageTitle('Акции. Чтобы завести Акцию, найдите карточку товара. Нажмите + во вкладке Акции')
            ->model('promotion')
            ->column(
                ColumnBuilder::build('product')
                    ->function(Promotion::class, 'productLink')
                    ->name('Товар')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('count')
                    ->name('От количества')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('unit')
                    ->name('единиц')
                    ->callback(function ($promotion){
                        return $promotion->unit->name??'не установлена';
                    })
                    ->get()
            )
            ->column(
                ColumnBuilder::build('active_till')
                    ->name('Действует до')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('new_price')
                    ->name('Цена по акции')
                    ->get()
            )
            ->edit()
            ->del()
            ->get();

        return $promotion;
    }

}