<?php

namespace app\blade;

use app\service\FS;
use eftec\bladeone\BladeOne;

class Blade extends BladeOne
{
    public function __construct()
    {
        $frameworkCaches = FS::platformSlashes(env('FRAMEWORK_CACHE'));
        $bladeViews      = FS::platformSlashes(env('BLADE_VIEWS'));

        parent::__construct(
            ROOT . $bladeViews . 'views',
            ROOT . $frameworkCaches . 'blade',
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


