<?php

namespace app\blade;

use app\service\FS;
use eftec\bladeone\BladeOne;

class Blade extends BladeOne
{
    public function __construct()
    {
        $bladeViews      = FS::platformSlashes(ROOT . env('BLADE_VIEWS') . '/views');
        $frameworkCaches = FS::platformSlashes(ROOT . env('FRAMEWORK_CACHE') . '/blade');

        parent::__construct(
            $bladeViews,
            $frameworkCaches,
            BladeOne::MODE_DEBUG,
            0
        );
    }

    public function setLayout($layout): static
    {
        $this->layout = $layout;
        return $this;
    }
}


