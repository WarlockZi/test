<?php


namespace app\view\components\Header\BlueRibbon;


use app\repository\delBlueRibbonRepository;
use Throwable;

class BlueRibbon
{

    public function __invoke(delBlueRibbonRepository $blueRibbonRepository): array
    {
        return $blueRibbonRepository::data();
    }


}