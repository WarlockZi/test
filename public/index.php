<?php

use app\service\AppService\App;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();
$app->run();

$app->handleRequest();

exit();
