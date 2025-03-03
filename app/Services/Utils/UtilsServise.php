<?php

namespace app\Services\Utils;

class UtilsServise
{

    public static function checkExtendion(string $extendion)
    {
        if(extension_loaded($extendion)) {
            $res ="{$extendion} OK";
        }else{
            $res ="{$extendion} UNAVAILABLE";
        }
//        echo $res;
//        exit($res);
    }

}