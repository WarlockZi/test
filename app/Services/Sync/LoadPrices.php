<?php

namespace app\Services\Sync;

use app\model\Price;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unit;

class LoadPrices
{
    private array $productIds = [];
    private array $data = [];

    public function __construct
    (
        readonly private string $file,
    )
    {
        $xml        = simplexml_load_file($this->file);
        $xmlObj     = json_decode(json_encode($xml), true);
        $this->data = $xmlObj['ПакетПредложений']['Предложения']['Предложение'];

        $this->run();
    }

    protected function run(): void
    {
        foreach ($this->data as $price) {
            $Price = $this->createPrice($price);
            $Unit  = $this->createUnit($price, $Price);

            if (Product::where('1s_id', $Price['1s_id'])
                ->update(['instore' => $price['Количество']])) {
                $this->productIds[] = $price['Ид'];
            }
            $this->unit2Product($Price, $Unit);
        }
    }

    protected function createPrice($price)
    {
        $pri['1s_id']  = $price['Ид'];
        $pri['1s_art'] = $price['Артикул'] ?? '';

        $pri['unit']      = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] ?? '';
        $pri['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'] ?? '';

        $pri['currency'] = $price['Цены']['Цена']['Валюта'] ?? '';
        $pri['price']    = $price['Цены']['Цена']['ЦенаЗаЕдиницу'] ?? '';

        return Price::updateOrCreate([
            '1s_id' => $price['Ид'],
            'unit_code' => $pri['unit_code'],
        ], $pri);
    }

    protected function createUnit($price, $Price)
    {
        return Unit::firstOrCreate(
            ['code' => $Price->unit_code],
            [
                'name' => $price['Цены']['Цена']['Единица'] ?? null,
                'code' => $Price->unit_code,
                'full_name' => $Price->unit,
            ]);

    }

    protected function unit2Product(Price $Price, Unit $Unit): void
    {
        $find = [
            'product_1s_id' => $Price['1s_id'],
            'unit_id' => $Unit['id'],
            'is_base' => '1',
        ];
        $new  = [
            'product_1s_id' => $Price['1s_id'],
            'unit_id' => $Unit['id'],
            'multiplier' => '1',
            'is_base' => '1',
            'is_shippable' => '1',
            'base_is_shippable' => '1',
        ];

        ProductUnit::firstOrCreate($find, $new);
    }

}