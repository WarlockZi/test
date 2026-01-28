<?php

namespace app\attributes;

use Attribute;
#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD)]

class Time
{
    public function __construct(...$arguments)
    {
        exit('Tmi');
        $ar = $arguments;
    }
}

