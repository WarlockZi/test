<?php

use app\Exceptions\AppErrorHandler;
use app\Request\Request;
use app\Services\AppService\App;
use app\Services\Logger\ErrorLogger;

try {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $app = new App();
    $app->run();

    $app->handleRequest(Request::capture());

    exit();
} catch (Throwable $exception) {
    $errorHandler = new AppErrorHandler(new ErrorLogger('errors/errors.txt'));
    $errorHandler->handleException($exception);
}