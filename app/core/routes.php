<?php

$this->add("^\/main/statii/kak-vybrat-kachestvennyye-meditsinskiye-perchatki-dlya-razlichnykh-sfer-deyatelnosti?$", ['controller' => 'Blog', 'action' => 'blog1']);
$this->add("^\/main/statii/meditsinskiye-prinadlezhnosti-kotoryye-dolzhny-byt-v-kazhdom-kabinete-vracha?$", ['controller' => 'Blog', 'action' => 'blog2']);

$this->add("^\/(?P<controller>product)\/?(?P<slug>[_a-z0-9-]+)$", ['controller' => 'Product']);
$this->add("^\/short\/(?P<slug>.+)?\/?$", ['controller' => 'Short']);

$this->add("^\/(?P<controller>catalog)\/(?P<slug>[_a-zA-Z0-9-\/%]+)?$", ['controller' => 'Category']);
$this->add("^\/(?P<controller>catalog)$", ['controller' => 'Category']);
$this->add("^\/(?P<controller>category)\/(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Category', 'redirect' => ['category' => 'catalog']]);
//$this->add("^\/(?P<controller>like)$", ['controller' => 'Like']);

$this->add("^\/(?P<controller>promotion)\/?(?P<slug>[_a-zA-Z0-9-]+)?$", ['controller' => 'Promotion']);
$this->add("^\/(?P<controller>main)\/(?P<action>[a-zA-Z0-9]+)$");
$this->add("^\/(?P<controller>logistic)\/(?P<action>[a-zA-Z0-9]+)$");
$this->add("^\/(?P<controller>auth)\/(?<action>[a-z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?");
$this->add("^\/.?search.?", ['controller' => 'search', 'action' => 'index']);
$this->add("^\/cart\/?(?P<action>[a-zA-Z]+)?$", ['controller' => 'Cart']);
$this->add("^\/adminsc\/?$", ['controller' => 'Adminsc', 'action' => 'index']);
$this->add("^\/adminsc\/?(?P<controller>[a-z-]+)?\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$");
$this->add("^\/$", ['controller' => 'Main', 'action' => 'index']);
$this->add("^\/(?P<controller>[a-zA-Z]+)\/?(?<action>[a-zA-Z0-9]+)?\/?(?<id>[0-9a-zA-z]+)?");
