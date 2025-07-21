<?php

//echo 'is console - '.isConsole()?'yes':'no';
//echo "dirname(__DIR__): " . dirname(__DIR__) . PHP_EOL;


$root = isConsole()//if app is started from cron
    ? dirname(getcwd(), 3)
    : dirname(__DIR__);

define("ROOT",$root);

require ROOT . '/app/service/bootstrap/session.php';

require ROOT . "/vendor/autoload.php";

require ROOT . '/app/service/bootstrap/dotenv.php';
require ROOT . '/app/service/bootstrap/helpers.php';
require ROOT . '/app/service/bootstrap/const.php';
require ROOT . '/app/service/bootstrap/profiler.php';
require ROOT . '/app/service/bootstrap/php.php';
require ROOT . '/app/service/bootstrap/errorHandler.php';

function isConsole(): bool
{
    if (!isset($_SERVER['SESSIONNAME'])) return false;
    if ($_SERVER['SESSIONNAME']!=='Console') return false;
    return true;
}