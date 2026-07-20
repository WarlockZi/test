<?php

use app\service\AppService\App;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();

error_log('after log');
$server = implode(',', $_SERVER);
error_log($server);
$app->handleRequest();

exit();