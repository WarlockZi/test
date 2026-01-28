<?php

namespace app\service\Sync\Load\Attributes\logger;

class LoggerHandler
{
    public static function execute(callable $callable, array $args = [])
    {
        // Получаем информацию о вызываемом методе
        $reflection = is_array($callable)
            ? new ReflectionMethod($callable[0], $callable[1])
            : new ReflectionFunction($callable);

        // Проверяем наличие атрибута Loggable
        $attributes = $reflection->getAttributes(Loggable::class);

        if (empty($attributes)) {
            return call_user_func_array($callable, $args);
        }

        /** @var Loggable $logAttribute */
        $logAttribute = $attributes[0]->newInstance();

        $startTime = microtime(true);

        try {
            $result = call_user_func_array($callable, $args);

            // Логируем успешное выполнение
            $message = $logAttribute->message ?? "Method {$reflection->getName()} executed successfully";
            Logger::log($logAttribute->level, $message, [
                'execution_time' => microtime(true) - $startTime,
                'arguments' => $args,
                'result' => $result
            ]);

            return $result;
        } catch (\Throwable $e) {
            // Логируем ошибку
            Logger::log('error', "Method {$reflection->getName()} failed", [
                'error' => $e->getMessage(),
                'execution_time' => microtime(true) - $startTime
            ]);
            throw $e;
        }
    }
}