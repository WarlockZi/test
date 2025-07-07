<?php

namespace app\service\Cache\Redis;

use app\service\Cache\BaseCache;
use app\service\Cache\ICache;
use Illuminate\Database\Eloquent\Collection;
use Predis\Client;
use Redis;

class Cache extends BaseCache implements ICache
{
    private static Client $redis;

    private function __construct()
    {
        parent::__construct();
        self::$redis = APP->get(Redis::class);
    }

    public static function has(string $key): bool
    {
        return self::$redis->exists($key);
    }

    public static function get(string $key): object|array|string|null
    {
        return self::$redis->exists($key)
            ? unserialize(self::$redis->get($key))
            : null;
    }

    public static function set(string $key, string|array|object $data, int $seconds = 6, string $path = ''): string|array|object|null
    {
        self::$redis->set($key, serialize($data), 'EX', $seconds);
        return $data;
    }

    public static function remember(
        string $key,
        callable $callable,
        int $seconds = 5): string|object|array|null
    {
        if (Cache::isEnabled()) {
            if (Cache::has($key)) {
                return Cache::get($key);
            } else {
                $data = $callable();
                return Cache::set($key, $data, $seconds);
            }
        }

        return $callable();
    }

    public static function forget($key): void
    {
        self::$redis->del($key);
    }

    public static function getInstance(): ?BaseCache
    {
        if (!self::$instance) {
            self::$instance = new self;
            return self::$instance;
        }
        return self::$instance;
    }

    private function __clone()
    {
    }


}
