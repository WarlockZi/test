<?php


namespace app\view\Order;


use app\model\Order;
use app\model\OrderItem;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\components\Builders\TableBuilder\TableHeader\TableHeader;
use app\view\MyView;
use Illuminate\Database\Eloquent\Collection;


abstract class OrderView
{

    public $model = Order::class;
    public $html;

    public static function listAll(): string
    {
        return Table::build(Order::all())
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наименование')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->edit()
            ->get();
    }

    public static function leadList($items): string
    {
        $list = Table::build($items)
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('user')
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
        return Table::build(Order::all())
            ->model('order')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('user')
                    ->function(Order::class, 'userEmail')
                    ->name('Клиент')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->edit()
            ->addButton('ajax')
            ->get();
    }

    public static function editOrder(Collection $orders): string
    {
        return Table::build($orders)
            ->pageTitle('Заказ')
            ->column(
                ColumnBuilder::build('id')
                    ->get()
            )
            ->header(
                TableHeader::build()
                    ->add('Клиент', $orders[0]->user->fi() ?? 'отсутствует')
                    ->get()
            )
            ->get();

    }

}