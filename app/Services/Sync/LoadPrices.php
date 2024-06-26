<?php

namespace app\Services\Sync;

use app\model\Price;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unit;

class LoadPrices extends Load
{
    protected Product $product;

    public function __construct($file)
    {
        parent::__construct($file, 'price');
        $this->run();
    }

    protected function run(): void
    {
        foreach ($this->data as $price) {
            $Price = $this->createPrice($price);
            $Unit  = $this->createUnit($price, $Price);

            $this->product = Product::where('1s_id', $Price['1s_id'])->first();

            $this->instore2Product($price);
            $this->unit2Product($Price, $Unit);
        }
    }

    protected function createPrice($price)
    {
        $g['1s_id']  = $price['Ид'];
        $g['1s_art'] = $price['Артикул'] ? $price['Артикул'] : '';

        $g['unit']      = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] ? $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'] : '';
        $g['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'] ? $price['БазоваяЕдиница']['@attributes']['Код'] : '';

        $g['currency'] = $price['Цены']['Цена']['Валюта'] ? $price['Цены']['Цена']['Валюта'] : '';
        $g['price']    = $price['Цены']['Цена']['ЦенаЗаЕдиницу'] ? $price['Цены']['Цена']['ЦенаЗаЕдиницу'] : '';

        return Price::create($g);
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

    protected function instore2Product($price): void
    {
        $this->product->update([
            'instore' => $price['Количество'],
        ]);
    }

    protected function unit2Product(Price $Price, Unit $Unit): void
    {
        $find = [
            'product_1s_id' => $Price['1s_id'],
            'unit_id' => $Unit['id'],
            'multiplier' => '1',
            'is_base' => '1',
        ];
        $new = [
            'product_1s_id' => $Price['1s_id'],
            'unit_id' => $Unit['id'],
            'multiplier' => '1',
            'is_base' => '1',
            'is_shippable' => '1',
            'base_is_shippable' => '1',
        ];

        ProductUnit::updateOrCreate($find, $new);
    }

    protected function ech($item)
    {
        echo "{$item->id} - {$item->price}<br>";
    }
}