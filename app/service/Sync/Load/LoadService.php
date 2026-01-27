<?php

namespace app\service\Sync\Load;

use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Sync\Load\Attributes\Measure\MeasurableTrait;
use app\service\Sync\Load\Attributes\Measure\MeasureTime;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class LoadService
{
    use MeasurableTrait;

    public function __construct(
        protected SyncLogger $logger = new SyncLogger(),
        protected array      $pricesData = [],
        protected array      $productsData = [],
        protected array      $categoriesData = [],

    )
    {
        $this->registerMeasuredMethod('loadCategories');
    }

    protected function setOfferData(): void
    {
        $file             = ROOT . env('SYNC_PATH') . env('SYNC_OFFER_FILE');
        $xml              = simplexml_load_file($file);
        $xmlObj           = json_decode(json_encode($xml), true);
        $this->pricesData = $xmlObj['ПакетПредложений']['Предложения']['Предложение'];
    }
    private function setImportFile()
    {
        $file               = ROOT . env('SYNC_PATH') . env('SYNC_IMPORT_FILE');
        $this->logger->write("--- xml file - $file ---");

        $xml                = simplexml_load_file($file);
        return json_decode(json_encode($xml), true);
    }

    protected function setProductsData(): void
    {
        $xmlObj = $this->setImportFile();
        $this->productsData = $xmlObj['Каталог']['Товары']['Товар'];
    }

    protected function setCategoriesData(): void
    {
        $xmlObj = $this->setImportFile();
        $this->categoriesData = $xmlObj['Классификатор']['Группы']['Группа']['Группы']['Группа'];
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn] public function run(): void
    {
        if (!extension_loaded('simplexml')) {
            $this->logger->write("--- Расширение SimpleXML НЕ установлено ---");
            if (function_exists('simplexml_load_file')) {
                $this->logger->write("---  функция simplexml_load_file не доступна ---");
            }
        }
        $this->LoadCategories();
        $this->LoadProducts();
        $this->LoadPrices();
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
        $this->setProductsData();
        $loadProducts = new LoadProducts();
        $loadProducts->load();

        $this->logger->write('--- products loaded  ---');
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn] public function LoadPrices(): void
    {
        $this->setOfferData();
        $loadPrices = new LoadPrices();
        $loadPrices->load();
    }
}