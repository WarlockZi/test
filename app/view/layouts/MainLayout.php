<?php

namespace app\view\layouts;

use app\service\AssetsService\UserAssets;
use app\view\components\Footer\UserFooter;
use app\view\components\Header\UserHeader;

class MainLayout extends Layout
{
   protected string $content;

    public function __construct(
        protected UserHeader $userHeader,
        protected UserFooter $userFooter,
        protected UserAssets $assets,
    )
    {
    }
    public function getAssets(): string
    {
        return $this->assets->getCss();
    }
    public function getLogo(): string
    {
        return APP->get('logo');
    }

    public function getFooter(): string
    {
        return  $this->userFooter->getFooter();
    }

}
