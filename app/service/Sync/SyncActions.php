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
    #[NoReturn] public function saveFiles(string $archiveDir): void
    {
        $this->logger->write('trying to safe file');

        $filename = $this->validateFilename($_GET['filename'] ?? '');
        $fileContent = file_get_contents('php://input');

        $filePath = $archiveDir. $filename;
        if (!file_put_contents($filePath, $fileContent)) {
            $this->failure('failed to save file');
        }
    }

    public function unzip(string $archiveDir, string $unzippedDir): void
    {
        if (!is_readable($archiveDir)) throw new SyncException('sync archive dir is not readable');
        if (!is_readable($unzippedDir)) throw new SyncException('sync unzip dir is not readable');

        try {
            $this->unzipFiles($archiveDir, $unzippedDir);
//            $this->cleanDir();
            $this->logger->write('Extraction successful!');
        } catch (Exception $e) {
            $this->logger->write('Extraction error!' . $e->getMessage());
        }
    }


    /**
     * @throws Exception
     */
    private function unzipFiles(string $zipFile, string $extractTo): void
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
                return;
            } catch (Exception $e) {
                $zip->close();
                throw new Exception("Extraction failed: " . $e->getMessage());
            }
        } else {
            throw new Exception("Failed open ZIP:" . $zipFile);
        }
    }
    #[NoReturn] public function validateFilename(string $filename): string
    {
        if (!$filename) {
            $this->failure('Filename not specified');
        }
        // basic security check
        if (preg_match('/\.\.|\/|\\\\/', $filename)) {
            $this->failure('Insecure filename');
        }
        return basename($filename);
    }
    #[NoReturn] public function checkauth(): void
    {
        $this->logger->write('checkauth');
        echo "success\n";                               /// success inc
        echo "sess_name **" . session_name() . "\n";    ///  777777
        echo session_id() . "\n";                       ///   55fdsa55;
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
        error_log($message.$_GET['type']);
        http_response_code(400);
        echo "failure\n";
        echo "$message";
        exit;
    }
}

