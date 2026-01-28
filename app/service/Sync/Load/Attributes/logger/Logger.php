<?php

namespace app\service\Sync\Load\Attributes\logger;

class Logger
{
    private static array $logEntries = [];

    public static function log(string $level, string $message, array $context = []): void
    {
        $entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'message' => $message,
            'context' => $context
        ];

        self::$logEntries[] = $entry;

        // Здесь можно добавить запись в файл, базу данных и т.д.
        echo "[{$entry['timestamp']}] {$level}: {$message} " .
            json_encode($context) . PHP_EOL;
    }

    public static function getLogs(): array
    {
        return self::$logEntries;
    }
}