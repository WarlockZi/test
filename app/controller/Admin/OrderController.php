<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Auth;
use app\core\Response;
use app\model\Order;
use app\model\OrderItem;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;
use Carbon\Carbon;


class OrderController extends AppController
{
   public $model = Order::class;

   public function __construct()
   {
      parent::__construct();
   }

   public function actionIndex()
   {
      $orderItems = OrderRepository::leadList();
      $leadlist = OrderView::leadList($orderItems);
      $orders = OrderRepository::clientList();
      $clientlist = OrderView::clientList($orders);
      $this->set(compact('clientlist', 'leadlist'));
   }

   public function actionEdit()
   {
      $orderId = $this->route->id;
      $orders = OrderRepository::edit($orderId);
      $this->set(compact('orders'));
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
                  'sess' => $_COOKIE['PHPSESSID'],
                  'user_id' => Auth::getUser()['id'],
                  'unit_id' => (int)$req['unit_id'],
                  'deleted_at' => null,
               ],
               [
                  'product_id' => $req['product_id'],
                  'sess' => $_COOKIE['PHPSESSID'],
                  'count' => (int)$req['count'],
                  'ip' => $_SERVER['REMOTE_ADDR'],
                  'unit_id' => (int)$req['unit_id'],
                  'updated_at' => $now,
               ]
            );
         }
         if ($order->wasRecentlyCreated) {
            Response::exitJson(['popup' => "Добавлено в корзину"]);
         }
         if ($order->wasChanged()) {
            Response::exitJson(['popup' => "Заказ изменен"]);
         }
         Response::exitJson(['popup' => 'не записано', 'error' => "не записано"]);
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
