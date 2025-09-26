<?php

namespace app\service\Sync\Trancate;

use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\service\Logger\SyncLogger;
use app\service\Response;
use app\traits\LoggerTrait;
use JetBrains\PhpStorm\NoReturn;

class TrancateService implements ITrancateService
{
    use LoggerTrait;

    public function __construct(
    )
    {
        $this->setLogger(new SyncLogger());
    }

    #[NoReturn] public function trancateAll(): void
    {
//		$this->removeCategories();
//		$this->removeProducts();
//		$this->removePrices();
    }

    #[NoReturn] public function removePrices(): void
    {
        Price::truncate();
        $this->log('--- price  deleted ---');
        Response::exitWithPopup('цены удалены');
    }

    #[NoReturn] public function removeProducts(): void
    {
        Product::truncate();
        $this->log('--- products  deleted ---');
        Response::exitWithPopup('товары удалены');
    }

    #[NoReturn] public function removeCategories(): void
    {
        Category::truncate();
        $this->log('--- category  deleted ---');
        Response::exitWithPopup('категории удалены');
    }
}