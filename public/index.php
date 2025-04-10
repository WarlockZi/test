<?php

use app\Services\Logger\ErrorLogger;
use app\Services\Router\Router;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$container = require __DIR__ . '/container.php';
define('APP', $container);

try {
    $router = APP->get(Router::class);
    $router->dispatch($container);
    exit();
} catch (Throwable $e) {
    if (DEV) {
        exit($e);
    }
    $logger = new ErrorLogger('errors/errors.txt');
    $logger->write($e);
}