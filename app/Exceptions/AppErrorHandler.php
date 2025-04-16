<?php

namespace app\Exceptions;

use app\Services\Logger\ErrorLogger;
use app\Services\Response;
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

    #[NoReturn] public function handleException($exception)
    {
        if (false) {
//        if (DEV) {

            exit($this->__toHtml($exception->getTrace()));
        } else {
            $this->logger->write($exception);

            $userMessage = $exception->getMessage();
            return Response::view('exceptions.router.badController', compact('userMessage'), 404);
        }
    }
    public function __toHtml(array $stackTrace): string
    {
        foreach ($stackTrace as $stackTraceItem) {
            echo " ({$stackTraceItem['line']})  {$stackTraceItem['class']} - {$stackTraceItem['function']}<br>";
        }
        return '';
    }

}