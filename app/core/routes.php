<?php

use app\core\Router;

Router::add("^product\/?(?P<slug>[a-z0-9-]+)?\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Product']);
Router::add("^category\/?(?P<slug>[a-z0-9-]+)?\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Category']);

Router::add("^about\/(?P<action>[a-z0-9_]+)$", ['controller' => 'main']);

Router::add("^product\/(?P<slug>)$", ['controller' => 'product']);

Router::add("^.?search.?", ['controller' => 'search', 'action' => 'index']);

Router::add("^auth\/?(?<action>[a-z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?$", ['controller' => 'Auth']);

Router::add("^cart\/?$", ['controller' => 'Cart']);

Router::add("^(?P<admin>adminsc)?\/?(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$");
//Router::add('^(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?$');
Router::add("^$", ['controller' => 'main', 'action' => 'index']);


