<?php

namespace app\service\Sync;

use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Sync\Load\LoadService;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use SimpleXMLElement;
use ZipArchive;


class SyncService
{
    private bool $softDelete = true;

    public function __construct(
        protected LoadService $loadService,
        protected SyncLogger  $logger,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function requestFrom1s(): void
    {
        header("Content-Type: text/plain; charset=utf-8");
        header("Pragma: no-cache");

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['type']) && $_GET['type'] === 'catalog') {

                if (isset($_GET['mode']) && $_GET['mode'] === 'checkauth') {

                    $this->logger->write('checkauth');
                    echo "success\n";                    /// success inc
                    echo "sess_name **" . session_name() . "\n"; ///  777777
                    echo session_id() . "\n"; ///   55fdsa55;
                    exit;
                }

                if (isset($_GET['mode']) && $_GET['mode'] === 'init') {
                    $this->logger->write('zip');
                    echo "zip=yes\n";
                    echo "file_limit=104857600\n"; // 100MB limit
                    exit;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->import();
        }

        http_response_code(400);
        echo "failure\n";
        echo "Invalid request";
    }

    /**
     * @throws Exception
     */
    private function import(): void
    {
        if (isset($_GET['mode']) && $_GET['mode'] === 'file') {
            $this->logger->write('file');

            if (!isset($_GET['filename'])) {
                http_response_code(400);
                echo "failure\n";
                echo "Filename not specified";
                exit;
            }

            $filename = $_GET['filename'];

            // Validate filename (basic security check)
            if (preg_match('/\.\.|\/|\\\\/', $filename)) {
                http_response_code(400);
                echo "failure\n";
                echo "Invalid filename";
                exit;
            }

            $importDir = FS::platformSlashes(ROOT . $this->importPath);
            if (!file_exists($importDir)) {
                mkdir($importDir, 0755, true);
            }

            $fileContent = file_get_contents('php://input');

            $filePath = $importDir . basename($filename);
            if (file_put_contents($filePath, $fileContent) !== false) {
                $this->load($filePath);
                $this->logger->write('Load успех' . PHP_EOL);
                $this->sendHTMLSuccessMessage();
            } else {
                http_response_code(500);
                echo "failure\n";
                exit("Failed to save file");
            }
        }

    }

    #[NoReturn] private function sendHTMLSuccessMessage(): void
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        echo "success\n";
        echo $date . "\n";
        echo $time . "\n";
        exit();
    }

    #[NoReturn] private function sendXMLSuccessMessage(): void
    {
        header('Content-Type: text/xml; charset=utf-8');

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><КоммерческаяИнформация></КоммерческаяИнформация>');
        $xml->addAttribute('ВерсияСхемы', '2.11');
        $xml->addAttribute('ДатаФормирования', date('Y-m-d'));

        $successNode = $xml->addChild('УспешноВыполнено');
        $successNode->addAttribute('xmlns', 'urn:1C.ru:commerceml_3');

        $successNode->addChild('Сообщение', 'Данные успешно загружены');

        echo $xml->asXML();
    }

//    #[NoReturn] protected function checkauth(): void
//    {
//        $this->log('checkauth');
//        if ($_GET['type'] == 'checkauth') {
//            header("Content-Type: text/plain; charset=utf-8");
//            echo "success\n";
//            echo session_name() . "\n";
//            echo session_id() . "\n";
//            // Или фиксированные значения, как в вашем примере:
//            // echo "success\nnic\n7777\n";
//            exit;
//        }
////        exit("success\ninc\n777777\n55fdsa55");
//    }

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
    public function load(string $filePath): void
    {
        try {
            $this->unzip($filePath);
            $this->importFilesExist();
            $this->loadService->load();
        } catch (\Throwable $e) {
            $this->logger->write("--- Ошибка load ", $e);
        }
    }

    public function unzip(string $filePath): void
    {
        $extractTo = ROOT . '/storage/app/sync/unzipped';
        try {
            $this->unzipFile($filePath, $extractTo);
            $this->cleanDir($filePath, $extractTo);
            $this->logger->write('Extraction successful!');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function cleanDir(): void
    {
        try {
            FS::delFilesFromPath($this->importPath, 'zip');
            $this->logger->write('Directory is clean');
        } catch (Exception $e) {
            echo 'Directory cleaning Error : ' . $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    public function unzipFile($zipFile, $extractTo): bool
    {
        if (!file_exists($zipFile)) {
            throw new Exception("ZIP file not found: $zipFile");
        }

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
            $errorMsg = [
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

            throw new Exception("Failed to open ZIP file: " . ($errorMsg[$res] ?? "Unknown error (code $res)"));
        }
    }


}

