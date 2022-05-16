<?php

use app\core\Router;

Router::add('^auth\/?(?<action>[a-z0-9]+)\/?(?<id>[0-9]+)$', ['controller' => 'Auth']);

Router::add('^about\/(?P<action>[a-z0-9_]+)$', ['controller' => 'main']);

Router::add('^service\/(?P<action>[a-z0-9-]+)$', ['controller' => 'main']);

Router::add('^.?search.?', ['controller' => 'search', 'action' => 'index']); // fw/ -> main/index
Router::add('^$', ['controller' => 'main', 'action' => 'index']); // fw/ -> main/index

Router::add('^adminsc\/(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$'); // fw/test/do -> controller/action
Router::add('^(?P<controller>[a-z-]+)\/?(?P<action>[a-z-]+)?$'); // fw/test/do -> controller/action


