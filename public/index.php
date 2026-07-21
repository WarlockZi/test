<?php

use app\service\AppService\App;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new App();

error_log(implodeServer());

function implodeServer(): string
{
    $str = '';
    foreach ($_SERVER as $k => $v) {
        $str .= $k . '=' . $v . '/r/n';
    }
    return $str;
}


$app->handleRequest();

exit();