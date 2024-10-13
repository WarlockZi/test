<?php

namespace app\controller;

use app\Actions\CartAction;
use app\controller\Admin\OrderController;
use app\controller\Admin\OrderitemController;
use app\core\Auth;
use app\core\Response;
use app\model\Lead;
use app\model\OrderItem;
use app\model\User;
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

    public function actionDrop()
    {
        if (!isset($this->ajax['cartToken'])) exit('No cart sess');
        $id = $this->ajax['cartToken'];
        OrderItem::query()
            ->where('sess', $id)
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::exitJson(['ok' => true]);

    }

    public function actionIndex(): void
    {
        $lead     = Lead::where('sess', session_id())->first();
        $user     = Auth::getUser();
        $products = CartRepository::main();

        $this->setVars(compact('products', 'lead', 'user'));
    }

    public function actionLogin()
    {
        $req  = $this->ajax;
        $user = User::where('email', $req['email'])->first();
        if ($user) {
            Auth::setAuth($user);
            $this->repo->convertOrderItemsToOrders($req, $user['id']);
            Response::exitJson(['ok' => true]);
        }
        Response::exitJson(['error' => 'Не правильные данные']);
    }


    public function actionLead()
    {
        $req  = $this->ajax;
        $lead = Lead::query()
            ->updateOrCreate([
                'name' => $req['name'],
                'phone' => $req['phone'],
                'company' => $req['company'],
                'sess' => $req['sess'],
            ], [$req]);

        if ($lead->wasChanged()) {
            Response::exitJson(['ok' => true, 'popup' => 'Заказ сохранен!']);
        }
        Response::exitJson(['ok' => true, 'popup' => 'Скоро мы Вам перезвоним!']);
    }

    public function actionDeleterow(): void
    {
        $product_id = $this->ajax['product_id'];
        $sess       = $this->ajax['sess'];
        $unit_ids   = $this->ajax['unit_ids'];

        if (!$product_id) Response::exitWithMsg('No id');
        $trashed = Auth::isAuthed()
            ? $this->orderRepo::deleteItems($sess, $product_id, $unit_ids)
            : $this->orderItemRepo->deleteItems($sess, $product_id, $unit_ids);
        if ($trashed) {
            Response::exitJson(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

    public function actionUpdateOrCreate(): void
    {
        if (Auth::isAuthed()) {
            OrderController::updateOrCreate($this->ajax);
        } else {
            OrderitemController::updateOrCreate($this->ajax);
        }
    }
}

