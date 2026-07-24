<?php

use app\service\AppService\App;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();

    error_log('public atest');
    error_log('REFERRER -'.$_SERVER['REFERRER']);
    error_log('uri -'.$_SERVER['REQUEST_URI']);
if (str_contains($_SERVER['REQUEST_URI'], '/adminsc/sync/init')) {
    error_log(' пришел запрос init---------------++---');
//error_log(implodeServer());
}

function implodeServer($str = ''): string
{
    foreach ($_SERVER as $k => $v) {
        $str .= $k . '=' . $v . '/r/n';
    }
    return $str;
}


$app->handleRequest();

exit();