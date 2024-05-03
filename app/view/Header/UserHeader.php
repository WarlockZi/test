<?php


namespace app\view\Header;


use app\core\FS;
use app\core\Icon;
use app\core\Route;
use app\view\Header\BlueRibbon\BlueRibbon;


class UserHeader
{
    protected string $header;
    protected FS $fs;

    public function __construct(Route $route)
    {
        $this->fs           = new FS(__DIR__ . '/templates');
        $data['blueRibbon'] = (new BlueRibbon())->getTemplate();
        $data['index']      = $route->isHome();
        $data['logo']       = Icon::logo_squre1() . Icon::logo_vitex1();
        $this->header       = $this->fs->getContent('vitex_header', $data);
    }

    public function getHeader()
    {
        return $this->header;
    }
}