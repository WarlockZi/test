<?php

namespace app\service\Cache;

interface ICache
{
    public static function set(string $key, string $data, int $seconds = 6, string $path = '');
    public static function get(string $key): string|array|object|null;
    public static function has(string $key):bool;

    public static function remember(string $key, callable $callable, int $seconds = 6): string|array|object|null;

    public static function forget($key);
    public static function enabled(bool $enabled = false):void;

}