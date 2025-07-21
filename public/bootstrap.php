<?php


$root = $_SERVER['SESSIONNAME'] === 'Console'//if app is started from cron
    ? dirname(getcwd(), 3)
    : ROOT;


require $root . '/app/service/bootstrap/session.php';

require $root . "/vendor/autoload.php";

require $root .'/app/service/bootstrap/dotenv.php';
require $root .'/app/service/bootstrap/helpers.php';
require $root .'/app/service/bootstrap/const.php';
require $root .'/app/service/bootstrap/profiler.php';
require $root .'/app/service/bootstrap/php.php';
require $root .'/app/service/bootstrap/errorHandler.php';
