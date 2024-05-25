<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Auth;
use app\core\Response;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;
use app\Repository\OrderitemRepository;
use Carbon\Carbon;


class OrderitemController extends AppController
{
   public $model = OrderItem::class;
   protected $repo;

   public function __construct()
   {
      parent::__construct();
      $this->repo = new OrderitemRepository();
   }

   public function actionToorder()
   {
      if ($this->ajax) {
         $form = $this->ajax['form'];
         $sess = $_SESSION['token'];
         $orderItems = OrderItem::where('sess', $sess)->get();
         $lead = Lead::create($form);
         $order = Order::create($form);
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
      $sess = $this->ajax['sess'];

      if (!$product_id) Response::exitWithMsg('No id');
      $trashed = $this->repo->deleteItem($this->model, $sess, $product_id);

      if ($trashed) {
         Response::exitJson(['ok' => true, 'popup' => 'Удален']);
      }
      Response::exitWithPopup('Не удален');

   }

   public function actionIndex()
   {


   }

   public function actionEdit()
   {
      $orderId = $this->route->id;
      $orderitems = $this->repo->edit($orderId);
      $this->set(compact('orderitems'));
   }

   public function actionUpdateOrCreate(): void
   {
      $req = $this->ajax;

      if ($req) {
         $now = Carbon::now()->toDateTimeString();
         {
            $orderItm = OrderItem::updateOrCreate(
               [
                  'product_id' => $req['product_id'],
                  'sess' => $_COOKIE['PHPSESSID'],
                  'deleted_at' => null,
                  'unit_id' => (int)$req['unit_id'],
               ],
               [
                  'product_id' => $req['product_id'],
                  'sess' => $_COOKIE['PHPSESSID'],
                  'count' => (int)$req['count'],
                  'unit_id' => (int)$req['unit_id'],
                  'ip' => $_SERVER['REMOTE_ADDR'],
                  'updated_at' => $now,
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
   }
}
