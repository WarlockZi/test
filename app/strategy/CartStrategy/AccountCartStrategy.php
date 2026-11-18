<?php

namespace app\strategy\CartStrategy;

use app\model\OrderItem;
use app\repository\OrderitemRepository;
use app\repository\OrderRepository;
use app\service\AuthService\AuthService;

class AccountCartStrategy implements ICartStrategy
{
    private int $account_id;

    public function __construct()
    {
        $this->account_id = AuthService::accountId();
    }

    public function deleteProduct(array $req)
    {
        $orderItems = $this->getProductOrderitems($req);
        foreach ($orderItems as $orderItem) {
            $orderItem->update(['count' => 0]);
        }
    }

    private function getProductOrderitems(array $req)
    {
        return OrderItem::where('account_id', $this->account_id)
            ->where('product_1s_id', $req['product_1s_id'])
            ->get();
    }

    public function getCart(int $account_id = null): array
    {
        $cart = (new OrderRepository)->accountCartsOrders($account_id ?? $this->account_id, false);
        return $cart;
    }

    public function getProductsInCart(int $account_id = null)
    {
        $cart = (new OrderitemRepository())
            ->getProductsInCart($account_id ?? $this->account_id)
            ->keyBy('1s_id');
        return $cart;
    }

    public function updateOrCreate($req): void
    {
         OrderItem::updateOrCreate(
                [
                    'account_id' => AuthService::accountId(),
                    'unit_id' => $req['unit_id'],
                    'product_1s_id' => $req['product_1s_id'],
                    'order_id' => $req['order_id'],
                ],
                [
                    'count' => $req['count'],
                ]
            );

    }

    public function cartCount(): int
    {
        $account_id = AuthService::accountId();
        $orderItems = OrderItem::query()
            ->where('account_id', $account_id)
            ->where('count', '>', 0)
            ->whereNull('order_id')
            ->distinct()
            ->count('product_1s_id')//            ->toSql()
        ;

        return $orderItems;
    }

    public function getItems()
    {
        $account_id = AuthService::accountId();
        return OrderItem::query()
            ->where('account_id', $account_id)
            ->get();
    }
}