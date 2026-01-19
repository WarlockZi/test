<?php

namespace app\service\Sync\Load;

use app\service\Logger\SyncLogger;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class LoadService
{
    public function __construct(
        protected SyncLogger   $logger = new SyncLogger(),
        protected array        $pricesData = [],
        protected array        $productsData = [],
        protected array        $categoriesData = [],
    )
    {
    }

    protected function setOfferData(): void
    {
        $file            = ROOT . env('SYNC_PATH') . env('SYNC_OFFER_FILE');
        $xml             = simplexml_load_file($file);
        $xmlObj          = json_decode(json_encode($xml), true);
        $this->pricesData = $xmlObj['ПакетПредложений']['Предложения']['Предложение'];
    }

    protected function setProductsData(): void
    {
        $file                 = ROOT . env('SYNC_PATH') . env('SYNC_IMPORT_FILE');
        $xml                  = simplexml_load_file($file);
        $xmlObj               = json_decode(json_encode($xml), true);
        $this->productsData   = $xmlObj['Каталог']['Товары']['Товар'];
    }
    protected function setCategoriesData(): void
    {
        $file                 = ROOT . env('SYNC_PATH') . env('SYNC_IMPORT_FILE');

        $xml                  = simplexml_load_file($file);
        $xmlObj               = json_decode(json_encode($xml), true);
        $this->categoriesData = $xmlObj['Классификатор']['Группы']['Группа']['Группы']['Группа'];
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn] public function run(): void
    {
        set_exception_handler([LoadErrorHandler::class,'handleException']);
        set_error_handler([LoadErrorHandler::class,'handleError']);
        $this->LoadCategories();
        $this->LoadProducts();
        $this->LoadPrices();
    }

    /**
     * @throws Exception
     */
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