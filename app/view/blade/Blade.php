<?php

namespace app\view\blade;

use app\Services\FS;
use eftec\bladeone\BladeOne;

class Blade extends BladeOne
{
    public function __construct(FS $fs)
    {
        $frameworkCaches = $fs::platformSlashes(env('FRAMEWORK_CACHE'));
        $bladeViews = $fs::platformSlashes(env('BLADE_VIEWS'));

        parent::__construct(
            ROOT . $bladeViews . 'views',
            ROOT . $frameworkCaches . 'blade',
            BladeOne::MODE_DEBUG,
            0
        );
    }
}


