<?php
declare(strict_types=1);

namespace app\controller;

use app\model\Order;
use app\model\OrderItem;
use app\Repository\CartRepository;
use app\Repository\OrderRepository;
use app\Services\Response;
use app\view\Cart\CartView;

class CartController extends AppController
{
    protected CartView $cartView;
    protected CartRepository $repo;

    public function __construct(CartView $cartView, CartRepository $repo)
    {
        parent::__construct();
        $this->cartView = $cartView;
        $this->repo     = $repo;
    }

    public function actionIndex(): void
    {
        $order = OrderRepository::cart();;
        $this->setVars(compact('order'));
    }

    public function actionDrop(): void
    {
        OrderItem::query()
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::json(['ok' => true]);
    }

    public function actionSubmit(): void
    {
        $orderId = $this->ajax['orderId'];
        if (empty($orderId)) exit('No cart order id');
        Order::find($orderId)->update(['submitted' => 1]);
//        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::json(['ok' => true]);
    }


    public function actionDeleterow(): void
    {
        $req        = $this->ajax;
        $product_id = $req['product_id'];
        $unit_ids   = $req['units'];

        if (!$product_id) Response::json(['msg' => 'No id']);
        $trashed = $this->orderRepo::detachItems($product_id, $unit_ids);

        if ($trashed) {
            Response::json(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

    public function actionUpdateOrCreate(): void
    {
        OrderRepository::updateOrCreate($this->ajax);
    }
}

