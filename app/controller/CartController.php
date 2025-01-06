<?php

namespace app\controller;

use app\core\Auth;
use app\core\Response;
use app\model\Order;
use app\model\OrderItem;
use app\Repository\CartRepository;
use app\Repository\OrderitemRepository;
use app\Repository\OrderRepository;
use app\view\Cart\CartView;

class CartController extends AppController
{
    protected CartView $cartView;
    protected CartRepository $repo;

    public function __construct(
        protected OrderRepository     $orderRepo = new OrderRepository(),
        protected OrderitemRepository $orderItemRepo = new OrderitemRepository(),
    )
    {
        parent::__construct();
        $this->cartView = new CartView();
        $this->repo     = new CartRepository();
    }
    public function actionIndex(): void
    {
        $user = Auth::getUser();
        $order = CartRepository::main();
//        $a = $order->toArray();

        $this->setVars(compact('order', 'user'));
    }

    public function actionDrop(): void
    {
        if (!isset($this->ajax['cartToken'])) exit('No cart sess');
        $id = $this->ajax['cartToken'];
        OrderItem::query()
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::exitJson(['ok' => true]);
    }

    public function actionSubmit(): void
    {
        $orderId = $this->ajax['orderId'];
        if (empty($orderId)) exit('No cart order id');
        Order::find($orderId)->update(['submitted' => 1]);
//        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::exitJson(['ok' => true]);
    }


    public function actionDeleterow(): void
    {
        $req = $this->ajax;
        $product_id =$req['product_id'];
        $unit_ids   = $req['units'];

        if (!$product_id) Response::exitWithMsg('No id');
        $trashed = $this->orderRepo::detachItems($product_id, $unit_ids);

        if ($trashed) {
            Response::exitJson(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

    public function actionUpdateOrCreate(): void
    {
        OrderRepository::updateOrCreate($this->ajax);
    }
}

