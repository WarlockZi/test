<?php

namespace app\service\Sync\Load\Attributes\logger;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Loggable
{
    public function __construct(
        public string $level = 'info',
        public ?string $message = null
    ) {}
}