<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use JetBrains\PhpStorm\NoReturn;
use SimpleXMLElement;


class SyncActions
{
    public function __construct(private SyncLogger $logger)
    {
    }


    #[NoReturn] public function checkauth(): void
    {
        $this->logger->write('checkauth');
        echo "success\n";                               /// success inc
        echo "sess_name **" . session_name() . "\n";    ///  777777
        echo session_id() . "\n";                       ///   55fdsa55;
        exit;
    }

    #[NoReturn] public function init(): void
    {
        $this->logger->write('zip');
        echo "zip=yes\n";
        echo "file_limit=104857600\n"; // 100MB limit
        exit;
    }

    #[NoReturn] public function validateFilename(string $filename): string
    {
        if (!$filename) {
            $this->failure('Filename not specified');
        }
        // basic security check
        if (preg_match('/\.\.|\/|\\\\/', $filename)) {
            $this->failure('Invalid filename');
        }
        return basename($filename);
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

