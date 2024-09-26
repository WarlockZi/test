<?php

use app\core\Auth;
use app\core\Router;

session_start();
$_SESSION['phpSession'] = session_id();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {
    $user = Auth::getUser();
//	$mockUser = \app\model\User::query()->find(160);
//	$Olya = \app\model\User::query()
//        ->where('email', 'vitex018@yandex.ru')
//        ->first();
//	Auth::setUser($Olya);

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


