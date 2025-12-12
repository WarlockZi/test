<?php

$errorsArray = [];
if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (function_exists('xdebug_enable')) {
        xdebug_enable();
    }
    set_error_handler('devErrorHandler');
    set_exception_handler('devExceptionHandler');
    register_shutdown_function('devShutdownHandler');
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
    $req0 = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'REQUEST_URI is empty';
    error_log(
        "Production exception: " . $exception->getMessage() . PHP_EOL .
        " in file: " . $exception->getFile() . PHP_EOL .
        " on line: " . $exception->getLine() . PHP_EOL .
        " TRACE: " . $exception->getTraceAsString() .
        " REQUEST0: " . $req0
    );

    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
        view('category.notFound');
//        include 'views/errors/500.html';
    }
}

function productionShutdownHandler($e): void
{
    $error = error_get_last();
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

function devErrorHandler($errno, $errstr, $errfile, $errline)
{
    $error = $errstr . "<br> in " . $errfile . "<br> on line " . $errline;
//    if (!headers_sent()) {
//        header('HTTP/1.1 500 Internal Server Error');
////        include ROOT.'/app/view/404/404.php';
//    }
//    response()->consoleLog($errstr);
    view('exceptions.error', compact('error'));
    // Don't execute PHP internal error handler
    return true;
}

function devExceptionHandler($exception): void
{
    $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'REQUEST_URI is empty';

    $trace    = $exception->getTrace();
    $traceStr = '';

    foreach ($trace as $key => $value) {
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