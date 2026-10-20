<?php

namespace app\controller;

use app\model\Like;

class Controller
{
    private $start;
    function __construct()
    {
        $this->start = microtime(true);

//        echo phpinfo();
    }
    public function __destruct()
    {

        $total = microtime(true) - $this->start;
//        echo "Время выполнения: " . ($end_time - $this->start) . " сек";
    }
}
