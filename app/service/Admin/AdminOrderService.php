<?php

namespace app\service\Admin;

use app\model\Account;
use app\repository\OrderRepository;

class AdminOrderService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new OrderRepository();
    }

    public function accountsUsersOrders(): array
    {
        return $this->repo->accountsUsersCartitemsOrders();
    }
    public function accountsOrders(): array
    {
        $orders = [];
        foreach (Account::all() as $account) {
            $orders[$account->id] = $this->repo::accountCartsOrders($account->id);
        }
        return $orders;
    }
}