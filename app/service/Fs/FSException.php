<?php

namespace app\service\Fs;

use Exception;
use Throwable;

class FSException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}