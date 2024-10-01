<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\core\Response;
use app\model\Order;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;
use Carbon\Carbon;

class OrderController extends AppController
{
    protected string $model = Order::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $orderItems = OrderRepository::leadList();
        $leadlist = OrderView::leadList($orderItems);

        $orders = OrderRepository::clientList();
        $clientlist = OrderView::clientList($orders);
        $this->setVars(compact('clientlist', 'leadlist'));
    }

    public function actionEdit():void
    {
        $this->view = 'table';
        $orders = OrderRepository::edit($this->route->id);
        $table = OrderView::editOrder($orders);
        $this->setVars(compact('table'));
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        if ($req) {
            $now = Carbon::now()->toDateTimeString();
            if (Auth::isAuthed()) {
                $order = Order::updateOrCreate(
                    [
                        'product_id' => $req['product_id'],
                        'unit_id' => (int)$req['unit_id'],
                        'sess' => session_id(),
                        'user_id' => Auth::getUser()['id'],
                        'deleted_at' => null,
                    ],
                    [
                        'product_id' => $req['product_id'],
                        'unit_id' => (int)$req['unit_id'],
                        'sess' => session_id(),
                        'count' => (int)$req['count'],
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'updated_at' => $now,
                    ]
                );
                if ($order->wasRecentlyCreated) {
                    Response::exitJson(['popup' => "Добавлено в корзину"]);
                }
                if ($order->wasChanged()) {
                    Response::exitJson(['popup' => "Заказ изменен"]);
                }
                Response::exitJson(['popup' => 'не записано', 'error' => "не записано"]);
            }
        }
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
            Response::exitJson(['ok' => 'ok', 'popup' => 'удален']);
        } catch (\Throwable $exception) {
            Response::exitJson(['error' => 'не удален', 'popup' => 'не удален']);
        }
    }
}
