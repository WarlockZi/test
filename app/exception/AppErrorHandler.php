<?php

namespace app\exception;

use app\service\Logger\ErrorLogger;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class AppErrorHandler extends \Error implements Throwable
{

    public function __construct(
        private ErrorLogger $logger
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function handleException($exception): string
    {
//        if (false) {
        if (DEV) {
            return false;
            exit($this->devMessage($exception));
        } else {
            $this->logger->write($exception);

            $userMessage = $exception->getMessage();
            return Response::view('exceptions.router.badController', compact('userMessage'), 404);
        }
    }

    public function devMessage($exception): string
    {
        echo "{$exception->getMessage()}<br>in file {$exception->getFile()} on line {$exception->getLine()}<br>";
        $stackTrace = $exception->getTrace();
        foreach ($stackTrace as $stackTraceItem) {
            $line = $stackTraceItem['line']??'';
            $class = $stackTraceItem['class']??'';
            $method = $stackTraceItem['function']??'';
            echo " ({$line})  {$class} - {$method}<br>";
        }
        return '';
    }

}