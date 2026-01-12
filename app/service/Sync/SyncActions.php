<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use SimpleXMLElement;
use ZipArchive;


class SyncActions
{
    public function __construct(private SyncLogger $logger)
    {
    }

    /**
     * @throws Exception
     */
    public function logRequest(array $req): void
    {
        $this->logger->write(implode(', ', array_map(
            fn($key, $value) => "$key: $value",
            array_keys($req),
            array_values($req)
        )));
    }

    /**
     * @throws Exception
     */
    public function saveFiles(string $archiveDir): string
    {
        $this->logger->write('trying to safe file');

        $filename    = $this->validateFilename($_GET['filename'] ?? '');
        $fileContent = file_get_contents('php://input');
        $filePath    = $archiveDir . $filename;

        if (!file_put_contents($filePath, $fileContent)) {
            $this->failure('failed to save file');
        }
        return $filePath;
    }

    /**
     * @throws Exception
     */
    public function unzip(string $filePath, string $unzippedDir): void
    {
        try {
            $this->unzipFiles($filePath, $unzippedDir);
//            $this->cleanDir();
            $this->logger->write('Extraction successful!');
        } catch (Exception $e) {
            $this->logger->write('Extraction error!' . $e->getMessage());
        }
    }


    public function createDirsIfNotExist(string $archiveDir, string $unzippedDir): void
    {
        if (!file_exists($archiveDir)) {
            if (!mkdir($archiveDir, 0755, true)) {
                throw new Exception("Failed to create directory: $archiveDir");
            }
        }
        if (!file_exists($unzippedDir)) {
            if (!mkdir($unzippedDir, 0755, true)) {
                throw new Exception("Failed to create directory: $unzippedDir");
            }
        }
    }

    /**
     * @throws Exception
     */
    private function unzipFiles(string $zipFile, string $unzippedDir): void
    {
        $zip = new ZipArchive;
        $res = $zip->open($zipFile);

        if ($res !== TRUE){
            throw new Exception("Failed open ZIP:" . $zipFile);
        }

        try {
            $zip->extractTo($unzippedDir);
            $zip->close();
            return;
        } catch (Exception $e) {
            $zip->close();
            throw new Exception("Extraction failed: " . $e->getMessage());
        }

    }

    public function validateFilename(string $filename): string
    {
        if (!$filename) {
            $this->failure('Filename not specified');
        }
        if (preg_match('/\.\.|\/|\\\\/', $filename)) {
            $this->failure('Insecure filename');
        }
        return basename($filename);
    }

    #[NoReturn] public function checkauth(): void
    {
        $this->logger->write('checkauth');
        echo "success\n";                               /// success inc
        echo "sess_name " . session_name() . "\n";    ///  777777
        echo 'sess_id ' . session_id() . "\n";                       ///   55fdsa55;
        exit;
    }

    /**
     * @throws \Exception
     */
    #[NoReturn] public function init(): void
    {
        $this->logger->write('zip');
        echo "zip=yes\n";
        echo "file_limit=600600\n"; // 600.6kB limit
        exit;
    }


    #[NoReturn] public function sendHTMLSuccessMessage(): void
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        echo "success\n";
        echo $date . "\n";
        echo $time . "\n";
        exit();
    }

    #[NoReturn] public function sendXMLSuccessMessage(): void
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

