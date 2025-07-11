<?php


if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (function_exists('xdebug_enable')) {
        xdebug_enable();
    }
} else {
    error_reporting(0);
    ini_set('display_errors', 0);

    set_error_handler('productionErrorHandler');
    set_exception_handler('productionExceptionHandler');
    register_shutdown_function('productionShutdownHandler');
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

function productionExceptionHandler($exception): void
{
    error_log(
        "Production exception: " . $exception->getMessage().PHP_EOL.
        " in file: " . $exception->getFile().PHP_EOL.
        " on line: " . $exception->getLine().PHP_EOL.
        " TRACE: " . $exception->getTraceAsString()
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
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        productionErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        view('category.notFound');

    }
}

