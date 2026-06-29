<?php

namespace app\attributes\Validate;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Validate
{
    public function __construct(
        public array $rules = []
    ) {}
}