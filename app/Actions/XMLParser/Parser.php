<?php

namespace app\Actions\XMLParser;

use app\Services\Logger\FileLogger;

class Parser
{
    protected $file;

    protected $logger;
    protected $data;

    public function __construct(string $file, string $type)
    {
        if (!is_readable($file)) exit();
        $this->file = $file;
        $this->logger = new FileLogger();
        $xml = simplexml_load_file($this->file);
        $xmlObj = json_decode(json_encode($xml), true);
        switch ($type) {
            case 'category':
                $this->data = $xmlObj['Классификатор']['Группы']['Группа']['Группы']['Группа'];
                break;
            case 'product':
                $this->data = $xmlObj['Каталог']['Товары']['Товар'];;
                break;
            case 'price':
                $this->data = $xmlObj['ПакетПредложений']['Предложения']['Предложение'];
                break;
            default:
                throw new \Exception('Пустые данные');
        }

    }

    protected function now()
    {
        return date("F j, Y, g:i a") . "\n";
    }


    protected function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    protected function log($content)
    {
        $this->logger->write($content);
    }

}