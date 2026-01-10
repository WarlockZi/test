<?php

namespace app\service\Sync;

use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadService;
use app\service\Zip\ZipErrorMessages;
use Exception;
use JetBrains\PhpStorm\NoReturn;


class SyncService
{
    private string $archiveDir = '';
    private string $importFile = '';
    private string $offerFile = '';
    private string $unzippedDir = '';


    use ZipErrorMessages;

    /**
     * @throws SyncException
     * @throws Exception
     */
    public function __construct(
        protected LoadService $loadService,
        protected SyncLogger  $logger,
        private SyncActions   $actions,
    )
    {
        $this->actions     = new SyncActions(new SyncLogger());
        $this->archiveDir  = ROOT . SyncStorage::getPath();
        $this->unzippedDir = ROOT . SyncStorage::getUnzippedDir();
        $this->importFile  = $this->unzippedDir . 'import0_1.xml';
        $this->offerFile   = $this->unzippedDir . 'offers0_1.xml';
        $this->actions->createDirsIfNotExist($this->archiveDir, $this->unzippedDir);
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function requestFrom1s(): void
    {
        header("Content-Type: text/plain; charset=utf-8");
        header("Pragma: no-cache");

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['type']) && $_GET['type'] === 'catalog') {

                if (isset($_GET['mode']) && $_GET['mode'] === 'checkauth') {
                    $this->actions->checkAuth();
                }

                if (isset($_GET['mode']) && $_GET['mode'] === 'init') {
                    $this->actions->init();
                }
            }
        }
        $cont = file_get_contents('php://input');
        $json = json_decode($cont, true);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->import();
        }
        $this->actions->badRequest();
    }

    /**
     * @throws Exception
     */
    #[NoReturn] private function import(): void
    {
        if (!isset($_GET['mode']) || $_GET['mode'] === 'file') {
            $this->actions->failure('Mode is not file');
        }
        $this->logger->write('import and load');
        $filePath = $this->actions->saveFiles($this->archiveDir);
        $this->actions->unzip($this->archiveDir, $this->unzippedDir, $filePath);
        $this->load();

    }

    /**
     * @throws Exception
     */
    private function importFilesExist(): void
    {
        if (!is_readable($this->importFile))
            throw new \Exception($this->importFile . 'import file not found');

        if (!is_readable($this->offerFile))
            throw new \Exception($this->offerFile . 'import file not found');
    }

//load

    /**
     * @throws Exception
     */
    public function load(): void
    {
        try {
            $this->importFilesExist();
            $this->loadService->run();
            $this->logger->write('Load успех' . PHP_EOL);
            $this->actions->sendHTMLSuccessMessage();
        } catch (\Throwable $e) {
            $this->logger->write("--- Ошибка load " . $e->getMessage());
        }
    }


    public function cleanDir(): void
    {
        try {
            FS::delFilesFromPath($this->archiveDir, 'zip');
            $this->logger->write('Directory is clean');
        } catch (\Throwable $e) {
            $this->logger->write('Directory cleaning Error : ' . $e->getMessage());
        }
    }

}

