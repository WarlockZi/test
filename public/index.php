<?php

use app\exception\AppErrorHandler;
use app\service\AppService\App;
use app\service\Logger\ErrorLogger;
use app\service\Router\IRequest;

try {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $app = new App();
    $app->run();

    $app->handleRequest(APP->get(IRequest::class)::capture());

    exit();
} catch (Throwable $exception) {
    $errorHandler = new AppErrorHandler(new ErrorLogger('errors/errors.txt'));
    $errorHandler->handleException($exception);
}