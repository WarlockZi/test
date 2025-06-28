<?php
declare(strict_types=1);

namespace app\view\layouts\Main\Header;

use app\view\components\Icon\Icon;

class MainHeader
{
    public function __construct()
    {
    }

    public function logo(): string
    {
        return Icon::logo_square1() . Icon::logo_vitex1();
    }

}