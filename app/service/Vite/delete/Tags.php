<?php

namespace app\service\Vite\delete;

/**
 * @see Manifest::createTags()
 */
class Tags
{
    public function __construct(
        public readonly string $preload = '',
        public readonly string $css = '',
        public readonly string $js = ''
    )
    {
    }
}
