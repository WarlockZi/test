<?php

namespace app\service\Sync\Load;

use app\model\Currency;
use app\model\Price;
use app\model\PriceType;
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

        $priceType = PriceType::updateOrCreate(
            ['1s-name' => '1s',],
            ['1s-name' => '1s',]
        );
        $currency['1s-name'] = $price['Цены']['Цена']['Валюта'] ?? '';

        $currency = Currency::updateOrCreate([
            '1s-name' => $currency['1s-name'],
        ], $currency);

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
            $this->pruductUnit($Price, $Unit);
        }
    }

    protected function createPrice($price)
    {



        ProductUnit::updateOrCreate(
            [

            ],
            [

            ]);

        $pri['currency_id'] = $currency->id;

        $pri['1s_id'] = $price['Ид'];

        $pri['unit_code']     = $price['БазоваяЕдиница']['@attributes']['Код'] ?? '';
        $pri['value']         = $price['Цены']['Цена']['ЦенаЗаЕдиницу'] ?? '';
        $pri['price-type_id'] = '1s';


        return Price::updateOrCreate([
            '1s_id' => $pri['1s_id'],
            'price-type_id' => $pri['price-type_id'],
            'currency_id' => $currency['id'],
        ], $pri);
    }

    protected function createCurrency($price)
    {
        $pri['1s_id'] = $price['Ид'];

        $pri['unit']      = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] ?? '';
        $pri['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'] ?? '';

        $pri['currency'] = $price['Цены']['Цена']['Валюта'] ?? '';
        $pri['price']    = $price['Цены']['Цена']['ЦенаЗаЕдиницу'] ?? '';

        return Price::updateOrCreate([
            '1s_id' => $pri['1s_id'],
            'unit_code' => $pri['unit_code'],
        ], $pri);
    }

    protected function createUnit($price, $Price)
    {
        return Unit::firstOrCreate(
            ['code' => $Price->unit_code],
            [
                'name' => lcfirst(substr($Price->unit, 0, 2)) ?? null,
                'international' => $price['Цены']['Цена']['Единица'] ?? null,
                'code' => $Price->unit_code,
                'full_name' => $Price->unit,
            ]);

    }

    protected function pruductUnit(Price $Price, Unit $Unit): void
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
        ];

        ProductUnit::firstOrCreate($find, $new);
    }

}