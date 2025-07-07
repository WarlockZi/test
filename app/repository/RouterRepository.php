<?php

namespace app\repository;

class RouterRepository
{
    public static function getRoutes(): array
    {
        return [
            ["^\/(?P<controller>product)\/?(?P<slug>[_a-z0-9-]+)$", ['controller' => 'Product']],
            ["^\/short\/(?P<slug>.+)?\/?$", ['controller' => 'Short']],

            ["^\/(?P<controller>catalog)\/(?P<slug>[_a-zA-Z0-9-\/%]+)?$", ['controller' => 'Category']],
            ["^\/(?P<controller>catalog)$", ['controller' => 'Category']],
            ["^\/(?P<controller>category)\/(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Category']],


            ["^\/(?P<controller>promotion)\/?(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Promotion']],
            ["^\/(?P<controller>main)\/(?P<action>[a-zA-Z0-9]+)$"],
            ["^\/(?P<controller>logistic)\/(?P<action>[a-zA-Z0-9]+)$"],
            ["^\/(?P<controller>auth)\/(?<action>[a-z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?"],
            ["^\/.?search.?", ['controller' => 'search', 'action' => 'index']],
            ["^\/cart\/?(?P<action>[a-zA-Z]+)?$", ['controller' => 'Cart'], [CartMiddleware::class, AuthMiddleware::class]],

            ["^\/adminsc\/?$", ['controller' => 'Adminsc', 'action' => 'index']],

            ["^\/adminsc\/?(?P<controller>[a-z-]+)?\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$"],
            ["^\/$", ['controller' => 'Main', 'action' => 'index']],
            ["^\/(?P<controller>[a-zA-Z]+)\/?(?<action>[a-zA-Z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?"],
        ];
    }

}