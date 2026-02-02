<?php

namespace app\service\Sync\Load;

use app\attributes\time\Time;
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

        protected      $importData;

    public function __construct(
        protected SyncLogger $logger = new SyncLogger(),
        protected array      $pricesData = [],
        protected array      $productsData = [],
        protected array      $categoriesData = [],

    )
    {
//        $this->registerMeasuredMethod('loadCategories');

    }

    protected function setOfferData(): void
    {
        $file             = ROOT . env('SYNC_PATH') . env('SYNC_OFFER_FILE');
        $xml              = simplexml_load_file($file);
        $xmlObj           = json_decode(json_encode($xml), true);
        $this->pricesData = $xmlObj['ПакетПредложений']['Предложения']['Предложение'];
    }
    private function setImportFile(): void
    {
        $file               = ROOT . env('SYNC_PATH') . env('SYNC_IMPORT_FILE');
        $this->logger->write("--- xml file - $file ---");
        $xml                = simplexml_load_file($file);
        $this->importData =  json_decode(json_encode($xml), true);
    }

    protected function setProductsData(): void
    {
        $this->productsData = $this->importData['Каталог']['Товары']['Товар'];
    }

    protected function setCategoriesData(): void
    {
        $this->categoriesData = $this->importData['Классификатор']['Группы']['Группа']['Группы']['Группа'];
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn]

    public function run(): void
    {
        if (!extension_loaded('simplexml')) {
            $this->logger->write("--- Расширение SimpleXML НЕ установлено ---");
            if (function_exists('simplexml_load_file')) {
                $this->logger->write("---  функция simplexml_load_file не доступна ---");
            }
        }
        try {
            $this->setImportFile();
            $this->LoadCategories();
            $this->LoadProducts();
            $this->LoadPrices();
        } catch (Throwable $exception) {
            $this->logger->write('load error - ' . $exception->getMessage());
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