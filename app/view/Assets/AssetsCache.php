<?php

namespace app\view\Assets;

class AssetsCache
{
    protected bool $cache = false;

    protected function getTime()
    {
        return ($this->cache) ? "?" . time() : "";
    }

    public function setCache(): void
    {
        $this->cache = $_ENV['DEV'] ? false : false;
    }

}