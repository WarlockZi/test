<?php
require dirname(__DIR__,2).'/controller/Admin/SyncController.php';
require dirname(__DIR__,2).'/controller/AppController.php';
require dirname(__DIR__,2).'/controller/Controller.php';

echo date("Y_m_d H:i:s") . " querry sent to sync/load" . PHP_EOL;

$syncController = new \app\controller\Admin\SyncController();
$syncController->actionLoad();

echo date("Y_m_d H:i:s")  . " loading (prod categ price and unit) done!". PHP_EOL. PHP_EOL;