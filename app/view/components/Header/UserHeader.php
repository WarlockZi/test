<?php
declare(strict_types=1);

namespace app\view\components\Header;


use app\Services\Router\Route;
use app\view\components\Header\BlueRibbon\BlueRibbon;


class UserHeader implements IHeader
{
    protected array $header;

    public function __construct(Route $route, BlueRibbon $blueRibbon)
    {
        $this->header['blueRibbon'] = $blueRibbon;
        $this->header['isHome']     = $route->isHome();
        $this->header['logo']       = APP->get('logo');
    }

    public function getHeader(): array
    {
        return $this->header;
    }
}