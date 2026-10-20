<?php

namespace app\controller;


use app\repository\OrderRepository;
use app\service\AuthService\AuthService;

class OrderController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $orders = OrderRepository::accountCartsOrders(AuthService::accountId());

        view('order.order', compact('orders'));

    }
}