<?php

namespace app\core;

class AuthValidator
{
    public static function check(Route $route)
    {
        return
            $route->controllerName === 'Auth' && $route->action === 'login'
            || $route->controllerName === 'Cart'
            || $route->controllerName === 'Main'
            || $route->controllerName === 'Bot'
            || $route->controllerName === 'Promotion'
            || $route->controllerName === 'Orderitem'
            || $route->controllerName === 'Search'

            || $route->controllerName === 'Sync' && $route->action === 'part'
            || $route->controllerName === 'Sync' && $route->action === 'init'
            || $route->controllerName === 'Sync' && $route->action === 'load'

            || $route->controllerName === 'Auth' && $route->action === 'register'
            || $route->controllerName === 'Auth' && $route->action === 'returnpass'
            || $route->controllerName === 'Auth' && $route->action === 'noconfirm'
            || $route->controllerName === 'Auth' && $route->action === 'confirm'
            || $route->controllerName === 'Main' && $route->action === 'index'
            || $route->controllerName === 'Product' && !$route->admin
            || $route->controllerName === 'Category' && !$route->admin
            || $route->controllerName === 'Github' && $route->action === 'webhook';
    }
}