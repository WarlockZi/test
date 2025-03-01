<?php


namespace app\view\Order;


use app\model\Order;
use app\model\OrderItem;
use app\model\User;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\components\Builders\TableBuilder\TableHeader\TableHeader;
use Illuminate\Database\Eloquent\Collection;


class OrderView
{
    public $model = Order::class;
    public $html;
    public static function orderItemEdit(Collection $items): string
    {
        $users = User::all();
        return Table::build($items)
            ->header(
                TableHeader::build()
                    ->add('Менеджер',
                        SelectBuilder::build(
                            ArrayOptionsBuilder::build($users)
                                ->get()
                        )
                        ->get())
                ->get()
            )
            ->pageTitle('Заказ незарегистрированного пользователя')
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->class('left')
                    ->callback(function ($item) {return $item->product->name??'нет';})
                    ->name('Наименование')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('count')
                    ->callback(fn ($item)=> $item->count??'0')
                    ->name('Количество')
                    ->width('50px')
                    ->get())
            ->column(
                ColumnBuilder::build('Единица')
                    ->callback(function ($item) {return $item->unit->name??'0';})
                    ->name('Единица')
                    ->width('60px')
                    ->get())
            ->get();
    }


    public static function table($items): string
    {
        $table = Table::build($items)
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('user')
                    ->class('left')
                    ->function(OrderItem::class, 'leadData')
                    ->name('Клиент')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('created_at')
                    ->class('left')
                    ->name('Дата')
                    ->search()
                    ->width('150px')
                    ->get())
            ->edit()
            ->get();
        return $table;
    }


    public static function editOrder(Order $order): string
    {
        return Table::build($order->products)
            ->model('order')
            ->pageTitle('Заказ')
            ->column(
                ColumnBuilder::build('id')
                    ->width("30px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Товар')
                    ->class('left')
                    ->callback(fn($product) =>
                    "<a href='/adminsc/product/edit/{$product->id}'>{$product->name}</a>"
                    )
                    ->width("1fr")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Картинка')
                    ->class('left img')
                    ->callback(fn($product) => "<img class='img' src='{$product->mainImage}' alt=''{$product->name}'>")
                    ->width("50px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Цена')
                    ->callback(fn($product) => $product->price)
                    ->width("60px")
                    ->get()
            )
            ->header(
                TableHeader::build()
                    ->add('Клиент', $order->user->fi() ?? 'отсутствует')
                    ->add('Email', $order->user->email ?? 'отсутствует')
                    ->add('Дата', $order->created_at ?? 'отсутствует')
                    ->get()
            )
            ->get();

    }

}