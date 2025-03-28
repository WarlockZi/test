<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$container = require __DIR__ . '/container.php';

try {
    $router = $container->get('Router');
    $router->dispatch($container);
    exit();
} catch (Throwable $e) {
    if (DEV) {
        exit($e);
    }
    $logger = new \app\Services\Logger\ErrorLogger();
    $logger->write($e);
}