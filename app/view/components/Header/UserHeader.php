<?php
declare(strict_types=1);

namespace app\view\components\Header;


use app\view\components\Icon\Icon;


class UserHeader
{


    public function logo(): string
    {
        return Icon::logo_square1() . Icon::logo_vitex1();
    }

}