<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadErrorHandler;
use app\service\Sync\Load\LoadService;
use app\service\Zip\ZipErrorMessages;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;


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
        set_exception_handler([LoadErrorHandler::class, 'handleException']);
        set_error_handler([LoadErrorHandler::class, 'handleError']);

        $this->actions = new SyncActions(new SyncLogger());

        $this->archiveDir  = ROOT . SyncStorage::getPath();
        $this->unzippedDir = ROOT . SyncStorage::getUnzippedDir();

        $this->importFile = $this->unzippedDir . 'import0_1.xml';
        $this->offerFile  = $this->unzippedDir . 'offers0_1.xml';

    }

    /**
     * @throws Exception
     * @throws \Throwable
     */
    #[NoReturn] public function requestFrom1s(): void
    {
        header("Content-Type: text/plain; charset=utf-8");
        header("Pragma: no-cache");
        $this->logger->write("uri - {$_SERVER['REQUEST_URI']}; method - {$_SERVER['REQUEST_METHOD']}");

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['type']) && $_GET['type'] === 'catalog') {

                if (isset($_GET['mode']) && $_GET['mode'] === 'checkauth') {
                    $this->actions->checkAuth();
                }

                if (isset($_GET['mode']) && $_GET['mode'] === 'init') {
                    $this->actions->clearUnzippedDir($this->unzippedDir);
                    $this->actions->init();
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->actions->createDirIfNotExist($this->archiveDir);
            $this->actions->createDirIfNotExist($this->unzippedDir);
            $this->import();
        }
        if ($this->actions->allFilesUnzipped($this->importFile, $this->offerFile)) {
            $this->actions->moveZips($this->archiveDir);
            $this->actions->respondAndContinue();
            $this->logger->write('Load started');
            try {
                $this->loadService->run();
            } catch (Throwable $exception) {
                $this->logger->write('load error - ' . $exception->getMessage());
            }
        }
    }

    /**
     * @throws Exception
     */
    #[NoReturn] private function import(): void
    {
        if (!isset($_GET['mode']) || $_GET['mode'] !== 'file') {
            throw new SyncException('$_GET[mode] is not file');
        }
        $filePath = $this->actions->saveFiles($this->archiveDir);
        $this->actions->unzip($filePath, $this->unzippedDir);
    }
}

