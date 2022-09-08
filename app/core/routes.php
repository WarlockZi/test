<?php

use app\core\Router;

Router::add("^auth\/?(?<action>[a-z0-9]+)?\/?(?<id>[0-9]+)?$", ['controller' => 'Auth']);
Router::add("^product\/(?<slug>[a-z0-9-]+)?\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Product']);
Router::add("^category\/(?<slug>[a-z0-9-]+)\/?(?<extra>[a-z0-9-]+)?$", ['controller' => 'Category']);

Router::add("^about\/(?P<action>[a-z0-9_]+)$", ['controller' => 'main']);

Router::add("^bibin$", ['controller' => 'bibin']);

Router::add("^.?search.?", ['controller' => 'search', 'action' => 'index']);

Router::add("^(?P<admin>adminsc)?\/?(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$");
//Router::add('^(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?$');
Router::add("^$", ['controller' => 'main', 'action' => 'index']);


