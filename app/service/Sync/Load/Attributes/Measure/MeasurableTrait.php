<?php

namespace app\service\Sync\Load\Attributes\Measure;

trait MeasurableTrait
{
    private static array $measurements = [];
    private array $measuredMethods = [];

    public function registerMeasuredMethod(string $methodName, string $displayName = null): void
    {
        $this->measuredMethods[$methodName] = $displayName ?? $methodName;
    }

    public function measuredCall(string $methodName, ...$args): mixed
    {
        if (!isset($this->measuredMethods[$methodName])) {
            return $this->$methodName(...$args);
        }

        $startTime = microtime(true);
        $memoryStart = memory_get_usage();

        try {
            $result = $this->$methodName(...$args);

            $this->recordMeasurement(
                $this->measuredMethods[$methodName],
                $startTime,
                microtime(true),
                $memoryStart,
                $result
            );

            return $result;
        } catch (\Throwable $e) {
            $this->recordMeasurement(
                $this->measuredMethods[$methodName],
                $startTime,
                microtime(true),
                $memoryStart,
                null,
                $e->getMessage()
            );
            throw $e;
        }
    }

    private function recordMeasurement(
        string $name,
        float $startTime,
        float $endTime,
        int $memoryStart,
        mixed $result = null,
        string $error = null
    ): void {
        $executionTime = ($endTime - $startTime) * 1000; // миллисекунды
        $memoryUsed = memory_get_usage() - $memoryStart;
        $memoryPeak = memory_get_peak_usage();

        self::$measurements[] = [
            'name' => $name,
            'time_ms' => round($executionTime, 2),
            'memory_bytes' => $memoryUsed,
            'memory_mb' => round($memoryUsed / 1024 / 1024, 4),
            'peak_memory_mb' => round($memoryPeak / 1024 / 1024, 4),
            'result_type' => gettype($result),
            'error' => $error,
            'timestamp' => date('H:i:s.v')
        ];
    }

    public static function getMeasurements(): array
    {
        return self::$measurements;
    }

    public static function clearMeasurements(): void
    {
        self::$measurements = [];
    }

    public static function printMeasurements(): void
    {
        echo "\n=== ВРЕМЯ ВЫПОЛНЕНИЯ МЕТОДОВ ===\n";
        echo str_pad("Метод", 30) .
            str_pad("Время (мс)", 15) .
            str_pad("Память (MB)", 15) .
            str_pad("Пик (MB)", 12) .
            "Время вызова\n";
        echo str_repeat("-", 100) . "\n";

        foreach (self::$measurements as $measurement) {
            echo sprintf(
                "%s %s %s %s %s\n",
                str_pad($measurement['name'], 30),
                str_pad($measurement['time_ms'] . ' ms', 15),
                str_pad($measurement['memory_mb'] . ' MB', 15),
                str_pad($measurement['peak_memory_mb'] . ' MB', 12),
                $measurement['timestamp']
            );

            if ($measurement['error']) {
                echo "   ОШИБКА: " . $measurement['error'] . "\n";
            }
        }
        echo str_repeat("=", 100) . "\n";
    }

    public static function printMeasurementsHtml(): void
    {
        echo '<div style="font-family: monospace; background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3 style="margin-top: 0;">Время выполнения методов</h3>';
        echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
        echo '<tr style="background: #e0e0e0;">';
        echo '<th>Метод</th><th>Время (мс)</th><th>Память (MB)</th><th>Пик (MB)</th><th>Время вызова</th>';
        echo '</tr>';

        foreach (self::$measurements as $measurement) {
            $color = $measurement['error'] ? '#ffdddd' : '#ffffff';
            echo '<tr style="background: ' . $color . ';">';
            echo '<td>' . htmlspecialchars($measurement['name']) . '</td>';
            echo '<td>' . $measurement['time_ms'] . ' ms</td>';
            echo '<td>' . $measurement['memory_mb'] . ' MB</td>';
            echo '<td>' . $measurement['peak_memory_mb'] . ' MB</td>';
            echo '<td>' . $measurement['timestamp'] . '</td>';
            echo '</tr>';

            if ($measurement['error']) {
                echo '<tr style="background: #ffdddd;">';
                echo '<td colspan="5"><strong>Ошибка:</strong> ' . htmlspecialchars($measurement['error']) . '</td>';
                echo '</tr>';
            }
        }
        echo '</table></div>';
    }
}