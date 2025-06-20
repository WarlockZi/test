<?php

namespace app\view\layouts\Main;


use app\view\layouts\Main\Header\MainHeader;
use app\views\layouts\Main\Footer\MainFooter;

class MainLayout
{
    public function __construct(
        protected MainHeader $header,
        protected MainFooter $footer,
    )
    {
    }

    public function header():MainHeader
    {
        return $this->header;
    }

    public function footer(): MainFooter
    {
        return $this->footer;
    }
}
