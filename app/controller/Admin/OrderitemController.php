<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Response;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;
use app\Repository\OrderitemRepository;
use app\view\Order\OrderView;
use Carbon\Carbon;


class OrderitemController extends AppController
{
    public function __construct(
        protected OrderView           $orderView = new OrderView(),
        protected OrderitemRepository $repo = new OrderitemRepository(),
    )
    {
        parent::__construct();
    }

    public function actionToorder(): void
    {
        if ($this->ajax) {
            $form       = $this->ajax['form'];
            $sess       = $_SESSION['phpSession'];
            $orderItems = OrderItem::where('sess', $sess)->get();
            $lead       = Lead::create($form);
            $order      = Order::create($form);
            $order->lead()->associate($lead);
            $order->save();
            foreach ($orderItems as $orderItem) {
                $orderItem->order()->associate($order);
                $orderItem->save();
            }
            Response::exitJson(['ok']);
        }
    }

    public function actionDelete(): void
    {
        $product_id = $this->ajax['product_id'];
        $sess       = $this->ajax['sess'];

        if (!$product_id) Response::exitWithMsg('No id');
        $trashed = $this->repo->deleteItem($sess, $product_id, $unit_ids);

        if ($trashed) {
            Response::exitJson(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

//    public function actionDeleterow(): void
//    {
//        $product_id = $this->ajax['product_id'];
//        $sess       = $this->ajax['sess'];
//        $unit_ids   = $this->ajax['unit_ids'];
//
//        if (!$product_id) Response::exitWithMsg('No id');
//        $trashed = $this->repo->deleteItems($sess, $product_id, $unit_ids);
//
//        if ($trashed) {
//            Response::exitJson(['ok' => true, 'popup' => 'Удален']);
//        }
//        Response::exitWithPopup('Не удален');
//    }

    public function actionIndex(): void
    {
    }

    public function actionEdit(): void
    {
        $this->view  = 'table';
        $orderitemId = $this->route->id;
        $orderitems  = $this->repo->edit($orderitemId);
        $table       = $this->orderView->orderItemEdit($orderitems['oItems']);
        $this->setVars(compact('table'));
    }

    public static function updateOrCreate(array $req): void
    {
        if (!$req) return;

        $orderItm = OrderItem::updateOrCreate(
            [
                'product_id' => $req['product_id'],
                'sess' => session_id(),
                'deleted_at' => null,
                'unit_id' => (int)$req['unit_id'],
            ],
            [
                'product_id' => $req['product_id'],
                'sess' => session_id(),
                'count' => (int)$req['count'],
                'unit_id' => (int)$req['unit_id'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );

        if ($orderItm->wasRecentlyCreated) {
            Response::exitJson(['popup' => "Добавлено в корзину"]);
        }
        if ($orderItm->wasChanged()) {
            Response::exitJson(['popup' => "Заказ изменен"]);
        }
        Response::exitJson(['popup' => 'не записано', 'error' => "не записано"]);
    }

}
