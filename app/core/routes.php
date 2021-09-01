<?php

use app\core\Router;

Router::add('^.?search.?', ['controller' => 'search', 'action' => 'index']); // fw/ -> main/index

//Router::add('^/(?P<action>[a-z]+)/(?P<alias>[0-9]+)$', ['controller' => 'Test']);

Router::add('^test/(?P<alias>[0-9]+)$', ['controller' => 'Test', 'action' => 'do']);
Router::add('^test/do$', ['controller' => 'Test', 'action' => 'do']);
//Router::add('^test/edit/(?P<id>[0-9]+)$', ['controller' => 'Test', 'action' => 'edit']);
//Router::add('^test/edit$', ['controller' => 'Test', 'action' => 'edit']);
Router::add('^test\/results\/(?P<cache>[a-zA-Z0-9]+)$', ['controller' => 'Test', 'action' => 'Results']);


Router::add('^question\/(?<action>[a-z]+)$', ['controller' => 'Question']);
Router::add('^answer\/(?<action>[a-z]+)$', ['controller' => 'Answer']);

Router::add('^user\/(?<action>[a-z]+)$', ['controller' => 'User']);

Router::add('^adminsc\/product\/edit\/(?P<id>[0-9]+)$', ['controller' => 'Adminsc', 'action' => 'ProductEdit']);

Router::add('^adminsc\/crm\/(?P<action>[0-9a-z]+)$', ['controller' => 'Adm_crm']);
Router::add('^adminsc\/crm$', ['controller' => 'Adm_crm']);

Router::add('^adminsc\/catalog\/(?P<action>[0-9a-z]+)$', ['controller' => 'Adm_catalog']);
Router::add('^adminsc\/catalog$', ['controller' => 'Adm_catalog']);

Router::add('^adminsc\/settings\/(?P<action>[0-9a-z]+)$', ['controller' => 'Adm_settings']);
Router::add('^adminsc\/settings\/instructions\/module\/(?P<id>[0-9]+)$', ['controller' => 'Adm_settings', 'action' => 'module']);

Router::add('^adminsc\/test\/update\/(?P<id>[0-9]+)$', ['controller' => 'Test', 'action' => 'update']);
Router::add('^adminsc\/test\/edit\/(?P<id>[0-9]+)$', ['controller' => 'Test', 'action' => 'edit']);
Router::add('^adminsc\/test\/show$', ['controller' => 'Test', 'action' => 'show']);
Router::add('^adminsc\/test\/pathshow$', ['controller' => 'Test', 'action' => 'pathshow']);

Router::add('^adminsc\/settings$', ['controller' => 'Adm_settings']);
Router::add('^adminsc$', ['controller' => 'Adminsc', 'action' => 'index']);

//Router::add('^catalog\/(?P<cat1>[a-z0-9-]+)\/?(?P<cat2>[0-9a-z-]+)?\/?(?P<cat3>[0-9a-z-]+)?\/?(?P<cat4>[0-9a-z-]+)?$', ['controller' => 'Product', 'action' => 'category']);

Router::add('^about\/(?P<action>[a-z0-9_]+)$', ['controller' => 'main']);
Router::add('^about$', ['controller' => 'main', 'action' => 'about']);

Router::add('^service\/(?P<action>[a-z0-9-]+)$', ['controller' => 'main']);

Router::add('^freetest\/?(?P<alias>[0-9]+)$', ['controller' => 'Freetest ', 'action' => 'do']);
Router::add('^freetest/edit/(?P<alias>[0-9]+)$', ['controller' => 'Freetest ', 'action' => 'edit']);
Router::add('^freetest/edit$', ['controller' => 'Freetest ', 'action' => 'edit']);
Router::add('^freetest$', ['controller' => 'Freetest']);
Router::add('^freetest/do$', ['controller' => 'Freetest', 'action' => 'do']);
Router::add('^freetest/results/(?P<cache>[a-zA-Z0-9]{32})$', ['controller' => 'Freetest', 'action' => 'Results']);

//Router::add("^(?<cat1>[a-z]+)\/?((?<cat2>[a-z]+)\/?)((?<cat3>[a-z]+)\/?)((?<cat4>[a-z]+)\/?)?$");// fw/sapogi/letnie -> category/categpry

Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$'); // fw/test/do -> controller/action

Router::add('^$', ['controller' => 'main', 'action' => 'index']); // fw/ -> main/index
