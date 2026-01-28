<?php

namespace app\attributes\time;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class Time
{
    public function __construct(
        public ?string $name = null,
        public string $unit = 'ms', // ms, s, ns
        public bool $logResult = true,
        public ?string $logLevel = 'debug',
        public ?string $threshold = null, // логировать только если больше threshold
        public array $context = []
    ) {}
}