<?php

use app\service\AppService\App;
use app\service\Router\IRequest;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();
$app->run();

$app->handleRequest();

exit();
