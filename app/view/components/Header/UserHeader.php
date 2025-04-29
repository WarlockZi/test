<?php
declare(strict_types=1);

namespace app\view\components\Header;


use app\service\AssetsService\UserAssets;
use app\service\Router\IRequest;
use app\view\components\Header\BlueRibbon\BlueRibbon;


class UserHeader implements IHeader
{
    protected array $header;

    public function __construct(IRequest $request, BlueRibbon $blueRibbon, UserAssets $assets)
    {
        $this->header['blueRibbon'] = $blueRibbon;
//        $this->header['isHome']     = $request->isHome();
//        $this->header['logo']       = APP->get('logo');
//        $this->header['assets']       = APP->get(UserAssets::class);
    }

//    public function getHeader(): array
//    {
//        return $this->header;
//    }
}