<?php

namespace app\Services\Cache\Memcached;

class Memcached
{
    public function __construct()
    {
        $m = new Memcached;
        if (method_exists($m, 'addServer')) {
            $m->addServer("localhost", 11211);
        } elseif (method_exists($m, 'connect')) {
            $m->connect("localhost", 11211);
        }
    }

    public function set($key, $value)
    {

    }

    public function get($key)
    {

    }

}