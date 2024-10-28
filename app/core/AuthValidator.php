<?php

namespace app\core;

class AuthValidator
{
    public static function needsNoAuth(Route $route)
    {
        return
            strtolower($route->controller) === 'auth' && $route->action === 'login'
            ||strtolower($route->controller) === 'auth' && $route->action === 'yandex'
            || strtolower($route->controller) === 'cart'
            || strtolower($route->controller) === 'main'
            || strtolower($route->controller) === 'bot'
            || strtolower($route->controller) === 'promotion'
            || strtolower($route->controller) === 'orderitem'
            || strtolower($route->controller) === 'order'
            || strtolower($route->controller) === 'search'

            || strtolower($route->controller) === 'sync' && $route->action === 'part'
            || strtolower($route->controller) === 'sync' && $route->action === 'init'
            || strtolower($route->controller) === 'sync' && $route->action === 'load'

            || strtolower($route->controller) === 'auth' && $route->action === 'register'
            || strtolower($route->controller) === 'auth' && $route->action === 'returnpass'
            || strtolower($route->controller) === 'auth' && $route->action === 'noconfirm'
            || strtolower($route->controller) === 'auth' && $route->action === 'confirm'
            || strtolower($route->controller) === 'main' && $route->action === 'index'
            || strtolower($route->controller) === 'product' && !$route->admin
            || strtolower($route->controller) === 'short'
            || strtolower($route->controller) === 'category' && !$route->admin
            || strtolower($route->controller) === 'github' && $route->action === 'webhook';
    }
}