<?php

use app\core\Router;

Router::add("^(?P<controller>product)\/?(?P<slug>[_a-z0-9-]+)?\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Product']);
Router::add("^(?P<controller>category)\/?(?P<slug>[_a-z0-9-]+)?\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Category']);
Router::add("^(?P<controller>promotion)\/?(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Promotion']);
Router::add("^(?P<controller>main)\/(?P<action>[a-zA-Z0-9]+)$");
Router::add("^(?P<controller>auth)\/(?<action>[a-z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?");
Router::add("^adminsc\/(?P<controller>sync)\/?(?P<action>[a-zA-Z0-9]+)\/?(?P<handler>1c_exchange.php)?(?P<extra>.+)?$");

Router::add("^.?search.?", ['controller' => 'search', 'action' => 'index']);

Router::add("^cart\/?(?P<action>[a-zA-Z]+)?$", ['controller' => 'Cart']);

Router::add("^(?P<admin>adminsc)\/?$", ['controller' => 'Adminsc','action'=>'index']);
Router::add("^(?P<admin>adminsc)\/?(?P<controller>[a-z-]+)?\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$");
Router::add("^$", ['controller' => 'Main', 'action' => 'index']);



