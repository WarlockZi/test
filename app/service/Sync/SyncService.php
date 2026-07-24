<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadService;
use app\service\Zip\ZipErrorMessages;
use Exception;
use Illuminate\Http\Request;
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
        $this->actions = new SyncActions($this->logger);

        $this->archiveDir  = ROOT . SyncStorage::getPath();
        $this->unzippedDir = ROOT . SyncStorage::getUnzippedDir();

        $this->importFile = $this->unzippedDir . env("SYNC_IMPORT_FILE");
        $this->offerFile  = $this->unzippedDir . env("SYNC_OFFER_FILE");
    }

    private function checkJson(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if ($input && isset($input['m'])) {
            $m = $input['m'];
            // Ваша логика здесь
            echo json_encode(['result' => 'success', 'm' => $m]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'php://input is empty']);
        }
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    #[NoReturn]
    public function requestFrom1s(): void
    {
//        $this->logger->write("");
//        $this->logger->write("uri - {$_SERVER['REQUEST_URI']}; method - {$_SERVER['REQUEST_METHOD']}");
//        header("Content-Type: text/plain; charset=utf-8");
//        header("Pragma: no-cache");

// Разрешаем CORS если нужно
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $this->checkJson();

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
//            $this->actions->clearUnzippedDir($this->unzippedDir);
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

