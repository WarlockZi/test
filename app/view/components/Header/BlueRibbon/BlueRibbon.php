<?php


namespace app\view\components\Header\BlueRibbon;


use app\repository\BlueRibbonRepository;
use Throwable;

class BlueRibbon
{

    public function __invoke(BlueRibbonRepository $blueRibbonRepository): array
    {
        return $blueRibbonRepository::data();
    }


}