<?php

namespace app\Services\Sync;

class Load
{
    protected mixed $data;

    public function __construct(string $file, string $type)
    {
        $xml = simplexml_load_file($file);
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
}