<?php

namespace app\exception\Cache;

class CacheError extends \Exception
{
    public function __toString():string
    {
        return $this->getMessage();
    }
}