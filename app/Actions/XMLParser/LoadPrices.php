<?php

namespace app\Actions\XMLParser;


use app\core\Response;
use app\model\Price;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unit;
use app\Services\Logger\ILogger;

class LoadPrices extends Parser
{

    protected $logger;
    protected Product $product;

    public function __construct($file, ILogger $logger)
    {
        parent::__construct($file, 'price');

        $this->logger = $logger;
        $this->logger->write('--- price    start ---' . $this->now());
        $this->run();
        $this->logger->write('--- price     stop ---' . $this->now());
    }

    protected function run()
    {
        foreach ($this->data as $price) {
            $Price = $this->createPrice($price);
            $Unit  = $this->createUnit($price, $Price);

            $this->product = Product::where('1s_id', $Price['1s_id'])->first();

            $this->instore2Product($price);
            $this->unit2Product($Price, $Unit);
        }
        Response::exitWithPopup('Загрузка цен, единиц и количества закончилась');
    }

    protected function createPrice($price)
    {
        $g['1s_id']  = $price['Ид'];
        $g['1s_art'] = $price['Артикул'] ? $price['Артикул'] : '';

        $g['unit']      = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] ? $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] : '';
        $g['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'] ? $price['БазоваяЕдиница']['@attributes']['Код'] : '';

        $g['currency'] = $price['Цены']['Цена']['Валюта'] ? $price['Цены']['Цена']['Валюта'] : '';
        $g['price']    = $price['Цены']['Цена']['ЦенаЗаЕдиницу'] ? $price['Цены']['Цена']['ЦенаЗаЕдиницу'] : '';

        $price = Price::create($g);
        return $price;
    }

    protected function createUnit($price, $Price)
    {
        $unit = Unit::where('code', $Price->unit_code)->first();
        if (!$unit) {
            $u['name']      = $price['Цены']['Цена']['Единица'] ?? null;
            $u['code']      = $Price->unit_code;
            $u['full_name'] = $Price->unit;
            $unit           = Unit::create($u);
        }
        return $unit;
    }

    protected function instore2Product($price)
    {
        $this->product->update([
            'instore' => $price['Количество'],
        ]);
    }

    protected function unit2Product(Price $Price, Unit $Unit)
    {
        $attrs       = [
            'product_1s_id' => $Price['1s_id'],
            'unit_id' => $Unit['id'],
            'is_base' => '1',
            'multiplier' => '1',
        ];
        $productUnit = ProductUnit::updateOrCreate($attrs, $attrs);
    }

    protected function ech($item)
    {
        echo "{$item->id} - {$item->price}<br>";
    }


}