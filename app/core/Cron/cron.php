<?php
$sync = dirname(__DIR__,2).'\\controller\\Admin\\SyncController.php';
$app = dirname(__DIR__,2).'\\controller\\AppController.php';
$con = dirname(__DIR__,2).'\\controller\\Controller.php';
require $con;
require $app;
require $sync;

echo date("Y_m_d H:i:s") . " querry sent to sync/load" . PHP_EOL;

$syncController = new \app\controller\Admin\SyncController();
$syncController->actionLoad();

echo date("Y_m_d H:i:s")  . " loading (prod categ price and unit) done!". PHP_EOL. PHP_EOL;