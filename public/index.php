<?php

use app\service\AppService\App;
use Illuminate\Http\Request;

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