<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use DirectoryIterator;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use SimpleXMLElement;
use ZipArchive;

class SyncActions
{
//    use TimeTrait;
    public function __construct(private SyncLogger $logger)
    {
    }

    /**
     * @throws Exception
     */
//    #[Time('Процесс обработки данных', logResult: true)]
    public function allFilesUnzipped(string $importFile, string $offerFile): bool
    {
        if (!is_readable($importFile)) {
            $this->logger->write($importFile.' is not readable');
            return false;
        }
        if (!is_readable($offerFile)) {
            $this->logger->write($offerFile.'  is not readable');
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function clearUnzippedDir(string $unzippedDir): void
    {
        $files = glob($unzippedDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function moveUnzippedToLoaded(string $unzippedDir): array
    {
        $files = glob($unzippedDir . '*');
        $loadedFiles = [];
        foreach ($files as $file) {
            if (is_file($file)) {
                $to = $unzippedDir.'loaded/'.basename($file);
                if (basename($file)===env('SYNC_OFFER_FILE')){
                    $loadedFiles['offerFile'] = $to;
                }
                if (basename($file)===env('SYNC_IMPORT_FILE')){
                    $loadedFiles['importFile'] = $to;
                }
                rename($file, $to);
            }
        }
        return $loadedFiles;
    }
    public function saveFiles(string $archiveDir): string
    {
        $filename    = $this->validateFilename($_GET['filename'] ?? '');
        $fileContent = file_get_contents('php://input');
        $filePath    = $archiveDir . $filename;

        if (!file_put_contents($filePath, $fileContent)) {
            $this->logger->write('failed to save file: ' . $filePath);
        }
        $this->logger->write('file saved to filePath: ' . $filePath);
        return $filePath;
    }


    public function unzip(SyncService $service): void
    {
        $zip = new ZipArchive;
        try {
            $zip->open($service->zipFileFullPath);
            $zip->extractTo($service->unzippedDir);
            $zip->close();
            $this->logger->write('extraction successful!');
            if (is_readable($service->offerFile)) {
                $this->logger->write('is readable - ' . $service->offerFile);
            }
            if (is_readable($service->importFile)) {
                $this->logger->write('is readable - ' . $service->importFile);
            }
            return;
        } catch (Exception $e) {
            $zip->close();
            $this->logger->write('extraction fail!' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function clearSyncDir(string $archiveDir): void
    {
        $iterator = new DirectoryIterator($archiveDir);
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->getType() === 'dir') continue;
            if ($fileInfo->isDot()) continue;
            if ($fileInfo->getExtension() !== 'zip') continue;

            $from = $fileInfo->getPathname();
            $to = $this->createDirToMove($archiveDir) . DIRECTORY_SEPARATOR . $fileInfo->getBasename();
            rename($from, $to);
        }
        $this->logger->write('move Zips success!');
    }

    /**
     * @throws Exception
     */
    private function createDirToMove(string $archiveDir): string
    {
        $day     = date('d');
        $month   = date('m');
        $dateDir = "{$month}_{$day}";
        return $this->createDirIfNotExist($archiveDir . $dateDir);
    }

    /**
     * @throws Exception
     */
    public function respondAndContinue(): void
    {
        ob_start();
        header('Content-Type: application/json');
        header('Content-Length: ' . ob_get_length());
        echo json_encode(['status' => 'all files accepted']);
        ob_end_flush();
        flush(); // Send output to browser
    }

    /**
     * @throws Exception
     */
    public function createDirIfNotExist(string $dir, int $rights = 0755, bool $recururcive = true): string
    {
        if (!file_exists($dir)) {
            if (!mkdir($dir, $rights, $recururcive)) {
                throw new Exception("Failed to create directory: $dir");
            }
        }
        return $dir;
    }

    /**
     * @throws SyncException
     */
    public function validateFilename(string $filename): string
    {
        if (!$filename) {
            $this->logger->write('Filename not specified');
        }
        if (preg_match('/\.\.|\/|\\\\/', $filename)) {
            $this->logger->write('Insecure filename');
        }
        return basename($filename);
    }

    #[NoReturn]
    public function checkauth(): void
    {
        $this->logger->write('checkauth');
        $sessId = '55fdsa55';
        echo "success\n";                               /// success inc
        echo "sess_name " . session_name() . "\n";    ///  777777
        echo 'sess_id ' . $sessId . "\n";             ///   55fdsa55;
        exit;
    }

    /**
     * @throws Exception
     */
    #[NoReturn]
    public function init(): void
    {
        $this->logger->write('zip');
        echo "zip=yes\n";
        echo "file_limit=600600\n"; // 600.6kB limit
        exit;
    }


    #[NoReturn]
    public function sendHTMLSuccessMessage(): void
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        echo "success\n";
        echo $date . "\n";
        echo $time . "\n";
        exit();
    }

    #[NoReturn]
    public function sendXMLSuccessMessage(): void
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

    #[NoReturn] public function badRequest(): void
    {
        $this->failure('Invalid request');
    }

    #[NoReturn] public function failure(string $message): void
    {
        error_log($message);
        http_response_code(400);
        echo "failure\n";
        echo "$message";
        exit;
    }

}

