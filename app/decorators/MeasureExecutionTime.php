<?php

namespace app\decorators;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MeasureExecutionTime
{
    private ?float $startTime = null;
    private ?float $endTime = null;

    public function start(): void
    {
        $this->startTime = microtime(true);
    }

    public function end(): void
    {
        $this->endTime = microtime(true);
    }

    public function getExecutionTime(): float
    {
        if ($this->startTime === null || $this->endTime === null) {
            return 0.0;
        }

        return round(($this->endTime - $this->startTime) * 1000, 2); // время в миллисекундах
    }

    public function getFormattedTime(): string
    {
        $time = $this->getExecutionTime();
        return $time >= 1000
            ? round($time / 1000, 2) . ' s'
            : $time . ' ms';
    }
}