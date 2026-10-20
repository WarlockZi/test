<?php

namespace app\strategy\CartStrategy;

use app\model\Product;
use Illuminate\Database\Eloquent\Collection;

class GuestCartStrategy implements ICartStrategy
{

    public function __construct(
        private string $sessionKey = 'cart_items',
    )
    {
    }
    public function getCart(): array
    {
        $cart     = $_SESSION['cart_items']??[];
        $ids      = array_keys($cart);
        $products = Product::query()
            ->whereIn('1s_id', $ids)
            ->get()
            ->append('shippable_units');
        $productsArray = $products->keyBy('1s_id')->toArray();
        foreach ($cart as $product_id => $units) {
            foreach ($units as $unit_id => $count) {
                $cart_item                             = ['unit_id' => $unit_id, 'count' => $count];
                $productsArray[$product_id]['cart_items'][] = $cart_item;
            }
        }
        return $productsArray;
    }

    public function updateOrCreate(array $req): void
    {
        $_SESSION[$this->sessionKey][$req['product_1s_id']][$req['unit_id']] = $req['count'];
        if ($req['count'] == 0) {
            unset($_SESSION[$this->sessionKey][$req['product_1s_id']][$req['unit_id']]);
        }
        if (!count($_SESSION[$this->sessionKey][$req['product_1s_id']])) {
            unset($_SESSION[$this->sessionKey][$req['product_1s_id']]);
        }
    }
    public function cartCount(): int
    {
        return isset($_SESSION[$this->sessionKey])
            ?count($_SESSION[$this->sessionKey])
            :0;
    }
    public function getItems(): array
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }
}