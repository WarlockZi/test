<?php


namespace app\view\Header;


use app\core\FS;
use app\core\Icon;
use app\core\Router;
use app\Repository\SettingsRepository;
use app\view\Header\BlueRibbon\BlueRibbon;


class UserHeader
{
    protected $header;
    protected $fs;
    protected array $data;

    public function __construct()
    {
        $this->fs = new FS(__DIR__ . '/templates/');
        $this->data['blueRibbon'] = (new BlueRibbon())->getTemplate();
        $this->data['index']      = Router::getRoute()->isHome();
        $this->data['logo']       = Icon::logo_squre1() . Icon::logo_vitex1();
        $this->header                   = $this->fs->getContent('vitex_header',$this->data);
    }

    public function getHeader()
    {
        return $this->header;
    }
}