<?php

namespace app\repository;

use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\model\ProductUnit;
use app\service\AuthService\AuthService;
use app\strategy\CartStrategy\AccountCartStrategy;
use app\strategy\CartStrategy\GuestCartStrategy;
use app\strategy\CartStrategy\ICartStrategy;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    private ICartStrategy $strategy;
    public function __construct()
    {
        $this->strategy = AuthService::accountId()
            ?new AccountCartStrategy()
            :new GuestCartStrategy();
    }

    public function getItems()
    {
        return $this->strategy->getItems();
    }

    public static function edit($id): Collection|array
    {
        $userId = Order::where('id', $id)->first()->user_id;
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user')
            ->groupBy('product_id')
            ->get();
        return $orders;
    }



}