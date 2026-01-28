<?php
// src/Traits/MeasurableTrait.php

namespace app\attributes\time;

use App\Attributes\MeasureExecutionTime;
use ReflectionMethod;

trait TimeTrait
{
    /**
     * @throws \ReflectionException
     * @throws \Throwable
     */
    protected function measure(string $method, array $args = [])
    {
        $reflection = new ReflectionMethod($this, $method);
        $attributes = $reflection->getAttributes(MeasureExecutionTime::class);

        if (empty($attributes)) {
            return $reflection->invokeArgs($this, $args);
        }

        $attribute = $attributes[0]->newInstance();
        $start = $this->getCurrentTime($attribute->unit);

        try {
            $result = $reflection->invokeArgs($this, $args);
            $end = $this->getCurrentTime($attribute->unit);
            $executionTime = $end - $start;

            $this->handleMeasurement($attribute, $executionTime, $method, $args, $result);

            return $result;
        } catch (\Throwable $e) {
            $end = $this->getCurrentTime($attribute->unit);
            $executionTime = $end - $start;

            $this->handleMeasurement($attribute, $executionTime, $method, $args, null, $e);
            throw $e;
        }
    }

    private function getCurrentTime(string $unit): float
    {
        return match($unit) {
            'ns' => hrtime(true),
            's' => microtime(true),
            default => microtime(true) * 1000 // ms
        };
    }

    private function handleMeasurement(
        MeasureExecutionTime $attribute,
        float $executionTime,
        string $method,
        array $args,
                             $result = null,
        ?\Throwable $exception = null
    ): void {
        $shouldLog = true;

        // Проверяем порог если задан
        if ($attribute->threshold !== null) {
            $threshold = $this->parseThreshold($attribute->threshold, $attribute->unit);
            $shouldLog = $executionTime > $threshold;
        }

        if (!$shouldLog || !$attribute->logResult) {
            return;
        }

        $this->logMeasurement($attribute, $executionTime, $method, $args, $result, $exception);
    }

    private function parseThreshold(string $threshold, string $unit): float
    {
        $value = (float) $threshold;

        // Поддержка форматов: "100ms", "0.5s", "100"
        if (str_ends_with($threshold, 'ms')) {
            return $value;
        } elseif (str_ends_with($threshold, 's')) {
            return $value * 1000; // конвертируем в ms
        } elseif (str_ends_with($threshold, 'ns')) {
            return $value / 1_000_000; // ns в ms
        }

        return $value;
    }

    private function logMeasurement(
        MeasureExecutionTime $attribute,
        float $executionTime,
        string $method,
        array $args,
                             $result,
        ?\Throwable $exception = null
    ): void {
        $message = $attribute->name ?? "Method {$method} execution time";

        $context = array_merge($attribute->context, [
            'execution_time' => $this->formatTime($executionTime, $attribute->unit),
            'execution_time_raw' => $executionTime,
            'unit' => $attribute->unit,
            'class' => static::class,
            'method' => $method,
            'memory_peak' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB',
        ]);

        if ($attribute->logResult && $result !== null) {
            $context['result'] = $this->formatResult($result);
        }

        if (!empty($args)) {
            $context['arguments'] = $this->formatArguments($args);
        }

        if ($exception) {
            $context['error'] = $exception->getMessage();
        }

        // Здесь можно использовать любой логгер
        $this->writeToLog($message, $context, $attribute->logLevel);
    }

    private function formatTime(float $time, string $unit): string
    {
        return match($unit) {
            'ns' => number_format($time) . ' ns',
            's' => number_format($time, 4) . ' s',
            default => number_format($time, 2) . ' ms'
        };
    }

    private function formatResult($result): mixed
    {
        if (is_object($result)) {
            return get_class($result);
        }

        if (is_array($result) && count($result) > 10) {
            return 'array[' . count($result) . ' items]';
        }

        return $result;
    }

    private function formatArguments(array $args): array
    {
        return array_map(function($arg) {
            if (is_object($arg)) {
                return get_class($arg);
            }

            if (is_array($arg) && count($arg) > 5) {
                return 'array[' . count($arg) . ' items]';
            }

            return $arg;
        }, $args);
    }

    private function writeToLog(string $message, array $context, ?string $level = 'debug'): void
    {
        // Простая реализация логирования
        $logEntry = sprintf(
            "[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level ?? 'debug'),
            $message,
            json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        // Запись в файл
        file_put_contents('execution_times.log', $logEntry, FILE_APPEND);

        // Вывод в консоль
        echo $logEntry;
    }
}