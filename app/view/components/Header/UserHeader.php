<?php


namespace app\view\components\Header;


use app\Services\FS;
use app\Services\Icon;
use app\Services\Router\Route;
use app\view\components\Header\BlueRibbon\BlueRibbon;
use Illuminate\Support\Collection;


class UserHeader
{
    protected string $header;
    protected FS $fs;

    public function __construct(Route $route, Collection $rootCategories)
    {
        $this->fs           = new FS(__DIR__ . '/templates');
        $data['blueRibbon'] = BlueRibbon::get();
        $data['index']      = $route->isHome();
        $data['logo']       = Icon::logo_square1() . Icon::logo_vitex1();
        $this->header       = $this->fs->getContent('vitex_header', $data);
    }

    public function getHeader():string
    {
        return $this->header;
    }
}