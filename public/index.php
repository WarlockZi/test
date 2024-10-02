<?php

use app\core\Router;
use \app\Services\UrlService;
use \app\Services\MockUserService;

session_start();
$_SESSION['phpSession'] = session_id();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {
//    MockUserService::mockUser();
//    UrlService::generateUrls();

    $router = new Router($_SERVER['REQUEST_URI'] ?? '');
    $router->dispatch();
    exit();
} catch (Throwable $e) {
    if ($_ENV['DEV'] === '0') {
        $logger = new \app\Services\Logger\ErrorLogger();
        $logger->write($e);
    }
    exit($e);
}