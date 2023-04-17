<?php

namespace app\Services\XMLParser;


use app\model\Price;
use app\model\Product;
use app\model\Unit;

class LoadPrices extends Parser
{
	protected $prices;

	public function __construct($file)
	{
		parent::__construct($file);
		$this->prices = $this->xmlObj['ПакетПредложений']['Предложения']['Предложение'];
		$this->run();
	}

	protected function run()
	{
		foreach ($this->prices as $price) {
			$this->fillGood($price);
		}
	}

	protected function fillGood($arr)
	{
		$price = $this->fillPrice($arr);

		$price = Price::create($price);

		$unit = Unit::where('code', $price->unit_code)->first();
		if (!$unit) {
			$unit = $this->createUnit($price);
		}

		$prod = Product::where('1s_id', $price['1s_id'])->first();
		if ($prod) {
			$prod->instore = $arr['Количество'] ? $arr['Количество'] : 0;
			$prod->baseUnit()->associate($unit);
			$prod->save();
//			$this->ech($prod,$id);
		}

	}

	protected function fillPrice($price)
	{
		$g['1s_id'] = $price['Ид'];
		$g['1s_art'] = $price['Артикул'];

		$g['unit'] = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'];
		$g['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'];

		$g['currency'] = $price['Цены']['Цена']['Валюта'];
		$g['price'] = $price['Цены']['Цена']['ЦенаЗаЕдиницу'];
		return $g;
	}

	protected function createUnit($price)
	{
		$u['code'] = $price->unit_code;
		$u['full_name'] = $price->unit;
		$u = Unit::create($u);
		return $u;
	}

	protected function ech($item)
	{
		echo "{$item->id} - {$item->price}<br>";
	}


}