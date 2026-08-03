<?php

namespace app\service\Sync\Load;

use app\service\Logger\SyncLogger;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class LoadService
{

    protected array $categoryData;
    protected array $productData;
    public array $priceData;
    protected SyncLogger $logger;

    protected array $attributes;


    public function __construct()
    {
        $this->logger = new SyncLogger();
    }


    public function run(): void
    {
        $this->checkXMLFuncExist();
        $this->moveFilesLoaded();

        $this->logger->write('**************');
        $this->LoadCategories();
        $this->LoadProducts();
        $this->LoadPrices();

    }

    private function moveFilesLoaded(): void
    {
        $this->moveImportFile(env('SYNC_IMPORT_FILE'));
        $this->moveImportFile(env('SYNC_OFFER_FILE'));
    }

    private function checkXMLFuncExist(): void
    {
        if (!extension_loaded('simplexml')) {
            $this->logger->write("--- Расширение SimpleXML НЕ установлено ---");
            if (function_exists('simplexml_load_file')) {
                $this->logger->write("---  функция simplexml_load_file не доступна ---");
            }
        }
    }

    private function moveImportFile(string $file)
    {
        $source = ROOT . env('SYNC_PATH') . 'unzipped/' . $file;
        if (!is_readable($source)) return false;

        $destination = ROOT . env('SYNC_PATH') . 'unzipped/loaded/' . $file;

        if (rename($source, $destination)) {
            return $destination;
        } else {
            response()->popup('Не удалось переместить разархивированный файл');
        }
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
//        $loadProducts = new LoadProductsBatching();

        $loadProducts = new LoadProducts();
        $loadProducts->load();

        $this->logger->write('--- products loaded  ---');
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn]
    public function LoadPrices(): void
    {
        $this->logger->write('--- price     load started ---');

        $loadPrices = new LoadPrices();
        $loadPrices->load();

        $this->logger->write('--- price     loaded ---');
    }
}