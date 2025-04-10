<?php


namespace app\view\components\Header\BlueRibbon;


use app\Repository\BlueRibbonRepository;
use Throwable;

class BlueRibbon
{

    public function __invoke(BlueRibbonRepository $blueRibbonRepository): array
    {
        try {
            $data = $blueRibbonRepository::data();
        } catch (Throwable $exception) {
            $exc = $exception;
        }
        return $data;

    }

}