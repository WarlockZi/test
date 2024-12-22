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
//            ->edit()
            ->get();
    }


    public static function leadList($items): string
    {
        $list = Table::build($items)
            ->model('orderitem')
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
            ->edit()
            ->get();
        return $list;
    }

    public static function clientList($items): string
    {
        return Table::build($items)
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('user')
                    ->class('left')
                    ->callback(fn(User $user)=>(string)$user->email)
                    ->name('Клиент')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->edit()
            ->addButton()
            ->get();
    }

    public static function editOrder(Collection $orders): string
    {
        return Table::build($orders)
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
                    ->callback(fn($order) => (string)
                    "<a href='/adminsc/product/edit/{$order->product->id}'>{$order->product->name}</a>"
                    )
                    ->width("1fr")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Картинка')
                    ->callback(fn($order) => "<img class='img' src='{$order->product->mainImage}' alt=''{$order->product->name}'>")
                    ->width("50px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Кол-во')
                    ->callback(fn($order) => (string)$order->count)
                    ->width("30px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Цена')
                    ->callback(fn($order) => (string)$order->product->price)
                    ->width("60px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Уп')
                    ->callback(fn($order) => (string)$order->unit->name)
                    ->width("40px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Акция')
                    ->callback(fn($order) => (string)$order->product->activePromotions)
                    ->width("50px")
                    ->get()
            )
            ->header(
                TableHeader::build()
                    ->add('Клиент', $orders[0]->user->fi() ?? 'отсутствует')
                    ->add('Email', $orders[0]->user->email ?? 'отсутствует')
                    ->add('Дата', $orders[0]->created_at ?? 'отсутствует')
                    ->get()
            )
            ->get();

    }
//    public static function listAll(): string
//    {
//        return Table::build(Order::all())
//            ->model('order')
//            ->column(
//                ColumnBuilder::build('id')
//                    ->name('ID')
//                    ->get())
//            ->column(
//                ColumnBuilder::build('name')
//                    ->name('Наименование')
//                    ->search()
//                    ->width('1fr')
//                    ->get())
//            ->edit()
//            ->get();
//    }
}