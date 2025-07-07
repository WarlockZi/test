<?php

namespace app\blade;

use app\service\FS;
use eftec\bladeone\BladeOne;

class Blade extends BladeOne
{
    public function __construct()
    {
        $bladeViews      = FS::platformSlashes(ROOT . env('BLADE_VIEWS') . '/views');
        $frameworkCaches = FS::platformSlashes(ROOT . env('CACHE_FRAMEWORK') . '/blade');
//        $mode            = DEV ? BladeOne::MODE_DEBUG : BladeOne::MODE_FAST;
        $mode = BladeOne::MODE_DEBUG;
//        $mode = BladeOne::MODE_FAST;

        parent::__construct(
            $bladeViews,
            $frameworkCaches,
            $mode,
            0
        );
    }
}


