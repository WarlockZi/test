<?php

namespace app\decorator;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class LogExecutionTime
{
    public function __construct()
    {
    }

    public function __invoke(callable $method): callable
    {
        return function (...$args) use ($method) {
            $start  = microtime(true);
            $result = $method(...$args);
            $end    = microtime(true);

            echo "Метод выполнился за: " . ($end - $start) . " секунд\n";
            return $result;
        };
    }
}