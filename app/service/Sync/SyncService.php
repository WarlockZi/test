<?php

namespace app\service\Sync;

use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadService;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use SimpleXMLElement;
use ZipArchive;


class SyncService
{
    private string $archiveDir = '';
    private string $importFile = '';
    private string $offerFile = '';
    private string $unzippedDir = '';
    private array $errorMsg = [
        ZipArchive::ER_EXISTS => 'File already exists',
        ZipArchive::ER_INCONS => 'Zip archive inconsistent',
        ZipArchive::ER_INVAL => 'Invalid argument',
        ZipArchive::ER_MEMORY => 'Malloc failure',
        ZipArchive::ER_NOENT => 'No such file',
        ZipArchive::ER_NOZIP => 'Not a zip archive',
        ZipArchive::ER_OPEN => 'Can\'t open file',
        ZipArchive::ER_READ => 'Read error',
        ZipArchive::ER_SEEK => 'Seek error',
    ];

    /**
     * @throws SyncException
     */
    public function __construct(
        protected LoadService $loadService,
        protected SyncLogger  $logger,
        private SyncActions   $actions,
    )
    {
        $this->actions    = new SyncActions(new SyncLogger());
        $this->archiveDir = ROOT . SyncStorage::getPath();
        $this->unzippedDir = ROOT. SyncStorage::getUnzippedDir();
        $this->importFile = $this->unzippedDir . 'import0_1.xml';
        $this->offerFile  = $this->unzippedDir . 'offers0_1.xml';
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->import();
        }

        $this->actions->badRequest();

    }

    /**
     * @throws Exception
     */
    private function import(): void
    {
        if (isset($_GET['mode']) && $_GET['mode'] === 'file') {
            $this->logger->write('file');

            $filename = $this->actions->validateFilename($_GET['filename'] ?? '');

            $fileContent = file_get_contents('php://input');

            $filePath = $this->unzippedDir . $filename;
            if (file_put_contents($filePath, $fileContent) !== false) {
                $this->load($filePath);
                $this->logger->write('Load успех' . PHP_EOL);
                $this->actions->sendHTMLSuccessMessage();
            } else {
                $this->actions->failure("Failed to save file");
            }
        }
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
            $this->unzip();
            $this->importFilesExist();
            $this->loadService->load();
        } catch (\Throwable $e) {
            $this->logger->write("--- Ошибка load ", $e);
        }
    }

    public function unzip(): void
    {
        if (!is_readable($this->archiveDir)) throw new Exception('sync unzip dir is not readable');

        try {
            $this->unzipFile($this->archiveDir, $this->unzippedDir);
//            $this->cleanDir();
            $this->logger->write('Extraction successful!');
        } catch (Exception $e) {
            $this->logger->write('Extraction error!'. $e->getMessage());
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

    /**
     * @throws Exception
     */
    public function unzipFile(string $zipFile, string $extractTo): bool
    {
        if (!file_exists($zipFile)) throw new Exception("ZIP file not found: $zipFile");

        if (!file_exists($extractTo)) {
            if (!mkdir($extractTo, 0777, true)) {
                throw new Exception("Failed to create directory: $extractTo");
            }
        } elseif (!is_writable($extractTo)) {
            throw new Exception("Destination is not writable: $extractTo");
        }

        $zip = new ZipArchive;
        $res = $zip->open($zipFile);

        if ($res === TRUE) {
            try {
                $zip->extractTo($extractTo);
                $zip->close();
                return true;
            } catch (Exception $e) {
                $zip->close();
                throw new Exception("Extraction failed: " . $e->getMessage());
            }
        } else {
            throw new Exception("Failed to open ZIP file: " . ($this->errorMsg[$res] ?? "Unknown error (code $res)"));
        }
    }
}

