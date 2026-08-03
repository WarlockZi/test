<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadService;
use app\service\Zip\ZipErrorMessages;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;


class SyncService
{
    public string $archiveDir = '';
    public string $unzippedDir = '';
    public string $importFile = '';
    public string $offerFile = '';
    public string $zipFileFullPath = '';

    use ZipErrorMessages;

    public function __construct(
        protected LoadService $loadService,
        protected SyncLogger  $logger,
        private SyncActions   $actions,
    )
    {
        $this->actions = new SyncActions($this->logger);

        $this->archiveDir  = SyncStorage::getSyncPath();
        $this->unzippedDir = SyncStorage::getUnzippedDir();

        $this->importFile = $this->unzippedDir . env("SYNC_IMPORT_FILE");
        $this->offerFile  = $this->unzippedDir . env("SYNC_OFFER_FILE");
    }



    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn]
    public function requestFrom1s(): void
    {
        $this->actions->setCORS();

        $this->actions->checkJson();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->logger->write('начата синхронизация request is get !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
            if (isset($_GET['type']) && $_GET['type'] === 'catalog') {

                if (isset($_GET['mode']) && $_GET['mode'] === 'checkauth') {
                    $this->actions->checkAuth();
                }

                if (isset($_GET['mode']) && $_GET['mode'] === 'init') {
                    $this->actions->init();
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->actions->createDirIfNotExist($this->archiveDir);
            $this->actions->createDirIfNotExist($this->unzippedDir);
            $this->actions->createDirIfNotExist($this->unzippedDir . 'loaded');
            $this->saveUnzip();
        }
        if ($this->actions->allFilesUnzipped($this->importFile, $this->offerFile)) {
            $this->actions->respondAndContinue();
            $this->logger->write('Load started');

            $loadedFiles      = $this->actions->moveUnzippedToLoaded($this->unzippedDir);
            $this->importFile = $loadedFiles['importFile'];
            $this->offerFile  = $loadedFiles['offerFile'];
            $this->loadService->run();

            $this->actions->clearSyncDir($this->archiveDir);
        }
    }

    #[NoReturn]
    private function saveUnzip(): void
    {
        if (!isset($_GET['mode']) || $_GET['mode'] !== 'file') {
            $this->logger->write('$_GET[mode] is not file');
        }
        $this->zipFileFullPath = $this->actions->saveFiles($this->archiveDir);
        $this->actions->unzip($this);
    }
}

