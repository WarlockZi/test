<?php

use app\service\AppService\App;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();

error_log('after log');
error_log($_SERVER['REQUEST_URI']);
$app->handleRequest();

exit();