<?php

namespace app\service\Sync\Load;

use app\service\Logger\SyncLogger;
use app\traits\LoggerTrait;

class LoadService
{
    use LoggerTrait;

    public function __construct(
        protected string $offerFile,
        protected string $importFile,
    )
    {
        $this->setLogger(new SyncLogger());
    }

    public function load(): void
    {
        $this->LoadCategories();
        $this->LoadProducts();
        $this->LoadPrices();
    }

    public function LoadCategories(): void
    {
        new LoadCategories($this->importFile);
        $this->log('--- category  loaded ---');
    }

    public function LoadProducts(): void
    {
        new LoadProducts($this->importFile);
        $this->log('--- products loaded  ---');
    }

    public function LoadPrices(): void
    {
        new LoadPrices($this->offerFile);
        $this->log('--- price     loaded ---');
    }

}