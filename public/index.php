<?php

use app\service\AppService\App;

$bootstrap = implode(DIRECTORY_SEPARATOR,
    [
        dirname(__DIR__),
        'app',
        'service',
        'bootstrap',
        'bootstrap.php'
    ]);


require_once $bootstrap;

$app = new App();

$app->handleRequest();

exit();