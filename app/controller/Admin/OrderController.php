<?php

namespace app\controller\Admin;

use app\core\Response;
use app\model\Order;
use app\model\OrderItem;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;
use Carbon\Carbon;

class OrderController extends AdminscController
{
    protected string $model = Order::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $submitted     = OrderRepository::submitted();
        $unsubmitted     = OrderRepository::unsubmitted();

        $submittedTable     = OrderView::table($submitted);
        $unsubmittedTable     = OrderView::table($unsubmitted);

        $this->setVars(compact('submittedTable', 'unsubmittedTable'));
    }

    public function actionEdit(): void
    {
        $this->view = 'table';
        $order     = OrderRepository::edit($this->route->id);
        $table      = OrderView::editOrder($order);
        $this->setVars(compact('table'));
    }

    public static function updateOrCreate(array $req): void
    {
        if (!$req) return;

        $order = OrderItem::updateOrCreate(
            [
                'product_id' => $req['product_id'],
                'unit_id' => (int)$req['unit_id'],
                'deleted_at' => null,
            ],
            [
                'product_id' => $req['product_id'],
                'unit_id' => (int)$req['unit_id'],
                'count' => (int)$req['count'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );
        if ($order->wasRecentlyCreated) {
            Response::json(['popup' => "Добавлено в корзину"]);
        }
        if ($order->wasChanged()) {
            Response::json(['popup' => "Заказ изменен"]);
        }
        Response::json(['popup' => 'не записано', 'error' => "не записано"]);
    }

    public function actionDelete(): void
    {
        $req = $this->ajax;
        try {
            foreach ($req['unit_ids'] as $unit_id) {
                Order::query()
                    ->where('product_id', $req['product_id'])
                    ->where('unit_id', $unit_id)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => Carbon::today()]);
            }
            Response::json(['ok' => 'ok', 'popup' => 'удален']);
        } catch (\Throwable $exception) {
            Response::json(['error' => 'не удален', 'popup' => 'не удален']);
        }
    }
}
