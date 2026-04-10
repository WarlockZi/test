<?php

namespace app\service\Sync\Load;

use app\service\Logger\SyncLogger;
use app\service\Sync\Load\Attributes\Measure\MeasurableTrait;
use app\service\Sync\Load\Attributes\Measure\MeasureTime;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class LoadService
{
    use MeasurableTrait;
       protected      array $categoryData;
        protected      array $productData;
        public      array $priceData;

    public function __construct(
        protected SyncLogger $logger = new SyncLogger(),
    )
    {
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn]

    public function run(): void
    {
        $this->checkXMLFuncExist();
        try {
            $this->LoadCategories();
            $this->LoadProducts();
            $this->LoadPrices();
        } catch (Throwable $exception) {
            $this->logger->write('load error - ' . $exception->getMessage());
        }
    }

    private function checkXMLFuncExist(){
        if (!extension_loaded('simplexml')) {
            $this->logger->write("--- Расширение SimpleXML НЕ установлено ---");
            if (function_exists('simplexml_load_file')) {
                $this->logger->write("---  функция simplexml_load_file не доступна ---");
            }
        }
    }
    /**
     * @throws Exception
     */
    #[MeasureTime('loadCategories')]
    public function LoadCategories(): void
    {
        $this->logger->write('--- category  load started ---');
        $loadCategories = new LoadCategories();
        $loadCategories->load();

        $this->logger->write('--- category  loaded ---');
    }

    /**
     * @throws Exception
     */
    public function LoadProducts(): void
    {
        $this->logger->write('--- products  load started ---');
        $loadProducts = new LoadProducts();
        $loadProducts->load();

        $this->logger->write('--- products loaded  ---');
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn] public function LoadPrices(): void
    {
        $loadPrices = new LoadPrices();
        $loadPrices->load();
    }
}