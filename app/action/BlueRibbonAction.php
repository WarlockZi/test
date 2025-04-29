<?php

namespace app\action;

use app\repository\BlueRibbonRepository;

class BlueRibbonAction
{
    public function __construct(
        private BlueRibbonRepository $repo,
    )
    {
    }

}