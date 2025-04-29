<?php

use app\middleware\AuthMiddleware;
use app\middleware\CartMiddleware;

$this->addRoute("^\/(?P<controller>product)\/?(?P<slug>[_a-z0-9-]+)$", ['controller' => 'Product']);
$this->addRoute("^\/short\/(?P<slug>.+)?\/?$", ['controller' => 'Short']);

$this->addRoute("^\/(?P<controller>catalog)\/(?P<slug>[_a-zA-Z0-9-\/%]+)?$", ['controller' => 'Category']);
$this->addRoute("^\/(?P<controller>catalog)$", ['controller' => 'Category']);
$this->addRoute("^\/(?P<controller>category)\/(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Category']);
//$this->addRoute("^\/(?P<controller>like)$", ['controller' => 'Like']);

$this->addRoute("^\/(?P<controller>promotion)\/?(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Promotion']);
$this->addRoute("^\/(?P<controller>main)\/(?P<action>[a-zA-Z0-9]+)$");
$this->addRoute("^\/(?P<controller>logistic)\/(?P<action>[a-zA-Z0-9]+)$");
$this->addRoute("^\/(?P<controller>auth)\/(?<action>[a-z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?");
$this->addRoute("^\/.?search.?", ['controller' => 'search', 'action' => 'index']);
$this->addRoute("^\/cart\/?(?P<action>[a-zA-Z]+)?$", ['controller' => 'Cart'], [CartMiddleware::class, AuthMiddleware::class]);
$this->addRoute("^\/adminsc\/?$", ['controller' => 'Adminsc', 'action' => 'index']);
$this->addRoute("^\/adminsc\/?(?P<controller>[a-z-]+)?\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$");
$this->addRoute("^\/$", ['controller' => 'Main', 'action' => 'index']);
$this->addRoute("^\/(?P<controller>[a-zA-Z]+)\/?(?<action>[a-zA-Z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?");
