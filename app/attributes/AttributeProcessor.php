<?php

namespace app\attributes;

use ReflectionException;
use ReflectionMethod;
use Throwable;

class AttributeProcessor
{
    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public static function process(object $object, string $method, array $arguments = []): mixed
    {
        $reflection = new ReflectionMethod($object, $method);
        $attributes = $reflection->getAttributes(MeasureExecutionTime::class);

        if (empty($attributes)) {
            return $object->$method(...$arguments);
        }

        /** @var MeasureExecutionTime $timer */
        $timer = $attributes[0]->newInstance();
        $timer->start();

        try {
            $result = $object->$method(...$arguments);
            $timer->end();

            self::logExecutionTime($object, $method, $timer);

            return $result;
        } catch (Throwable $e) {
            $timer->end();
            self::logExecutionTime($object, $method, $timer, true);
            throw $e;
        }
    }

    private static function logExecutionTime(
        object               $object,
        string               $method,
        MeasureExecutionTime $timer,
        bool                 $isError = false
    ): void
    {
        $className = get_class($object);
        $status    = $isError ? 'ERROR' : 'SUCCESS';
        $time      = $timer->getFormattedTime();

        $message = sprintf(
            "[%s] %s::%s executed in %s",
            $status,
            $className,
            $method,
            $time
        );

// Можно записать в лог, вывести в консоль или отправить в мониторинг
        error_log($message);
        echo $message . PHP_EOL;
    }
}