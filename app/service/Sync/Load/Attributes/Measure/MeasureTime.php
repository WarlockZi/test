<?php

namespace app\service\Sync\Load\Attributes\Measure;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MeasureTime
{
    public function __construct(
        public string $name
    ) {}
}