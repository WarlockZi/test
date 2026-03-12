<?php

use JetBrains\PhpStorm\NoReturn;

$errorsArray = [];
if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    if (function_exists('xdebug_enable')) {
        xdebug_enable();
    }
    set_error_handler('devErrorHandler');
    set_exception_handler('devExceptionHandler');
    register_shutdown_function('devShutdownHandler');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', "On");

    set_error_handler('productionErrorHandler');
    set_exception_handler('productionExceptionHandler');
//    register_shutdown_function('productionShutdownHandler');
}

function productionErrorHandler($errno, $errstr, $errfile, $errline)
{
    error_log("Production Error [$errno]: $errstr in $errfile on line $errline");
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
        view('category.notFound');
//        include ROOT.'/app/view/404/404.php';
    }
    // Don't execute PHP internal error handler
    return true;
}


function trace(): false|string
{
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
    $trace_info = [];

    foreach ($backtrace as $index => $trace) {
        $trace_info[] = sprintf(
            "#%d %s:%d - %s%s%s()",
            $index,
            $trace['file'] ?? 'internal',
            $trace['line'] ?? 0,
            $trace['class'] ?? '',
            $trace['type'] ?? '',
            $trace['function'] ?? ''
        );
    }
    return json_encode($trace_info);
}
function productionExceptionHandler($exception): void
{
    $req0 = $_SERVER['REQUEST_URI'] ?? 'REQUEST_URI is empty';
    $referrer = $_SERVER['HTTP_REFERER'] ?? ' no referrer';
    $eol = "";

    $trace = $exception->getTraceAsString();
//    $trace = trace();

    error_log(
        "Production exception: " . $exception->getMessage() . $eol .
        " in file: " . $exception->getFile() . $eol .
        " on line: " . $exception->getLine() . $eol .
        " TRACE: " . $trace . $eol.
        " **** REFERRER ****: " . $referrer . $eol .
        " REQUEST0: " . $req0
    );

    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
        view('category.notFound');
//        include 'views/errors/500.html';
    }
}

function productionShutdownHandler(): void
{
    $error = error_get_last();
    if (is_array($error)) {
        $error = implode(' | ', $error);
    }
    error_log("Production shutdownHandler: " . $error);
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        productionErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        view('category.notFound');
    }
}


function devShutdownHandler(): void
{
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        devErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

#[NoReturn] function devErrorHandler($errno, $errstr, $errfile, $errline): void
{
    $error = $errstr . "<br> in " . $errfile . "<br> on line " . $errline;
    view('exceptions.error', compact('error'));
}

#[NoReturn] function devExceptionHandler($exception): void
{
    $url = $_SERVER['REQUEST_URI'] ?? 'REQUEST_URI is empty';

    $trace    = $exception->getTrace();
    $traceStr = '';

    foreach ($trace as $value) {
        $traceStr .= 'class: ' . ($value['class'] ?? 'no class name') . '<br>' .
            'function: ' . '<b>' . ($value['function'] ?? 'no function name') . '</b>' . " : " . ($value['line'] ?? 'no line number') . "<br><br>";
    }

    $lines = [
        $exception->getMessage() . " : Dev exception<br>",
        "file: " . $exception->getFile() . " : " . $exception->getLine(),
        "URL: " . $url . "<br>",
        "TRACE: <br><br>" . $traceStr,
    ];

    exit(implode("<br>", $lines));

}