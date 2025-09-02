<?php

namespace app\service\Sync\Trancate;

use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\service\Response;
use app\traits\LoggerTrait;

class SoftTrancateService implements ITrancateService
{
    use LoggerTrait;

    public function trancateAll(): void
    {
        $this->removeCategories();
        $this->removeProducts();
        $this->removePrices();
    }
    public function removeProducts(): void
    {
        foreach (Product::all() as $model) {
            $this->softDelete($model);
        }
        $this->log('--- products  soft deleted ---');
        Response::exitWithPopup('товары удалены');
    }

    public function removePrices(): void
    {
        Price::truncate();
        $this->log('--- price  soft deleted ---');
        Response::exitWithPopup('цены удалены');

    }

    public function removeCategories(): void
    {
        foreach (Category::all() as $model) {
            $this->softDelete($model);
        }
        $this->log('--- category  soft deleted ---');
        Response::exitWithPopup('категории удалены');
    }
}