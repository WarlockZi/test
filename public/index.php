<?php

use app\service\AppService\App;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
error_log('---App---defined'.defined('APP'));
$app = new App();

$app->handleRequest();

exit();