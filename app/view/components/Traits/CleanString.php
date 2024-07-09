<?php

namespace app\view\components\Traits;

trait CleanString
{
    public function clean(string $res):string
    {
        $regex[0] = "/\r\r+?/";
        $regex[1] = "/\n\n+?/";
        $res = preg_replace($regex, "", $res);

        $regex = "/\t\t+?/";
        $res = preg_replace($regex, "\t", $res);

        $regex = "/\r\n\t+?/";
        $res = preg_replace($regex, "\t", $res);
        $res = str_replace("\r\n\r\n", "\r\n", $res);

        return $res;
    }

}