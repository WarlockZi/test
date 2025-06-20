<?php

namespace app\service\Cache;

use Psr\SimpleCache\CacheInterface;

class BaseCache
{
    protected static bool $enabled = true;
    public static int $timeLife1 = 1;
    public static int $timeLife10 = 10;
    public static int $timeLife100 = 100;
    public static int $timeLife1_000 = 1000;
    public static int $timeLife10_000 = 10000;
    protected static $instance = null;

    protected function __construct()
    {
    }

    public static function isEnabled(): bool
    {
        return self::$enabled;
    }
    public static function enabled(bool $enabled = false): void
    {
        self::$enabled = $enabled;
    }


}