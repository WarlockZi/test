<?php

namespace app\strategy\CartStrategy;

use app\model\OrderItem;
use app\model\Product;
use app\repository\OrderRepository;
use app\service\AuthService\AuthService;

class AccountCartStrategy implements ICartStrategy
{
    private int $account_id;

    public function __construct()
    {
        $this->account_id = AuthService::accountId();
    }

    public function getCart(int $account_id = null): array
    {
        $cart = (new OrderRepository)->accountCartsOrders($account_id, false);
//        $accCart = Product::query()
//            ->whereHas('cartItems', function ($q) {
//                $q->where('account_id', $account_id ?? $this->account_id)
//                    ->whereNull('order_id')
//                    ->where('count', '>', 0);
//            })
//            ->with(['cartItems' => function ($q) {
//                return $q->where('account_id', $account_id ?? $this->account_id)
//                    ->whereNull('order_id')
//                    ->leftJoin('product_unit', function ($join) {
//                        return $join
//                            ->on('orderitems.unit_id', '=', 'product_unit.unit_id')
//                            ->on('orderitems.product_1s_id', '=', 'product_unit.product_1s_id');
//                    })
//
////                    ->withUnitDetails()
//                    ;
//            }])
//            ->get()
//            ->append('shippable_units');

        return $cart;
//        return $accCart->toArray();
    }

    public function updateOrCreate($req): void
    {
        OrderItem::updateOrCreate(
            [
                'unit_id' => $req['unit_id'],
                'product_1s_id' => $req['product_1s_id'],
            ],
            [
                'unit_id' => $req['unit_id'],
                'product_1s_id' => $req['product_1s_id'],
                'count' => $req['count'],
            ]
        );
    }

    public function cartCount(): int
    {
        $account_id = AuthService::accountId();
        return OrderItem::query()
            ->where('account_id', $account_id)
            ->where('count', '>', 0)
            ->whereNull('order_id')
            ->distinct()
            ->count('product_1s_id');
    }

    public function getItems()
    {
        $account_id = AuthService::accountId();
        return OrderItem::query()
            ->where('account_id', $account_id)
            ->get();
    }
}