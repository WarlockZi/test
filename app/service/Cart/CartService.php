<?php

namespace app\service\Cart;

use app\service\AuthService\AuthService;

class CartService
{
    public static function getCartFieldValue(): array
    {
        $user  = AuthService::getUser();
        $field = $user ? 'user_id' : 'vitex_guest_id';
        $value = $user ? $user->id : $_COOKIE['vitex_guest_id'] ?? NULL;
        return [$field, $value];
    }

}