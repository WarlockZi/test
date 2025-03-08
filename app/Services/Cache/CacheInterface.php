<?php

namespace app\Services\Cache;

interface CacheInterface
{
    public function set($key, $value, $expire);
    public function get($key);
}