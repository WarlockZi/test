<?php


namespace app\Services;


use app\model\ProductProperty;

class ShortlinkService
{
    /**
     * @param string $name
     * @return string
     */
    public static function create(int $length = 8): string
    {
        $arr = [
            '1234567890',
            'abcdefghijklmnopqrstuvwxyz',
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        ];

        $pass = array();

        $arrLength = count($arr) - 1;
        $y         = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($y > $arrLength) $y = 0;
            $arrChosen     = $arr[$y];
            $arrChosernLen = strlen($arrChosen) - 1;
            $n             = rand(0, $arrChosernLen);
            $pass[]        = $arrChosen[$n];
            $y++;
        }
        return implode($pass);
    }

    public static function getValidShortLink(): string
    {
        $short = ShortlinkService::create(12);
        $found = ProductProperty::where('short_link', $short)->first();
        while ($found) {
            $short = ShortlinkService::create(12);
            $found = ProductProperty::where('short_link', $short)->first();
        }
        return $short;
    }

}