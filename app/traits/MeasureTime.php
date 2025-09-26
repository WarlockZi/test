<?php

namespace app\traits;

trait MeasureTime
{
    protected function measureTime(
        object $class,
        string $function,
                 ...$args
    ): void
    {
        $start  = microtime(true);
        $class->{$function}(...$args);
        $time   = microtime(true) - $start;

        $response["Время выполнения: "] = number_format($time, 2, '.', ' ') . " секунд";
        $response["Память: "]           = number_format(memory_get_usage() / 1024 / 1024,2) . " MB";
        $response["Пиковая память: "]   = number_format(memory_get_peak_usage() / 1024 / 1024,2) . " MB";

        response()->consoleLog([$response]);
    }

    protected function logTime(string $label, int $timeNs): void
    {
        $timeMs = $timeNs / 1_000_000;
        echo "Выполнено за: {$timeMs} ms\n";

        // file_put_contents('timing.log', "...", FILE_APPEND);
    }

}