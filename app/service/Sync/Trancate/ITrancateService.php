<?php

namespace app\service\Sync\Trancate;

interface ITrancateService
{
    public function removeProducts(): void;
    public function removePrices(): void;
    public function removeCategories(): void;
    public function trancateAll(): void;
}