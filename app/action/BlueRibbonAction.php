<?php

namespace app\action;

use app\repository\delBlueRibbonRepository;

class BlueRibbonAction
{
    public function __construct(
        private delBlueRibbonRepository $repo,
    )
    {
    }

}