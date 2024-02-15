<?php

namespace app\Actions\XMLParser;


use app\model\Price;
use app\model\Product;
use app\model\Unit;
use app\Services\Logger\ILogger;

class LoadPrices extends Parser
{
	protected $prices;
	protected $logger;

	public function __construct($file, ILogger $logger)
	{
		parent::__construct($file);

		$this->prices = $this->xmlObj['ПакетПредложений']['Предложения']['Предложение'];
		$this->logger = $logger;
		$this->logger->write('--- price    start ---' . $this->now());
		$this->run();
		$this->logger->write('--- price     stop ---' . $this->now());
	}

	protected function run()
	{
		foreach ($this->prices as $price) {
			$Price = $this->createPrice($price);
			$Unit = $this->createUnit($price, $Price);
			$this->attachPriceUnitToProduct($Price, $Unit, $price);
		}
	}

	protected function createPrice($price)
	{
		$g['1s_id'] = $price['Ид'];
		$g['1s_art'] = $price['Артикул'];

		$g['unit'] = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'];
		$g['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'];

		$g['currency'] = $price['Цены']['Цена']['Валюта'];
		$g['price'] = $price['Цены']['Цена']['ЦенаЗаЕдиницу'];

		$price = Price::create($g);
		return $price;
	}

	protected function createUnit($price, $Price)
	{
		$unit = Unit::where('code', $Price->unit_code)->first();
		if (!$unit) {
			$u['name'] = $price['Цены']['Цена']['Единица'] ?? mull;
			$u['code'] = $Price->unit_code;
			$u['full_name'] = $Price->unit;
			$unit = Unit::create($u);
		}
		return $unit;
	}

	protected function attachPriceUnitToProduct(Price $Price, Unit $Unit, $price)
	{
		$prod = Product::where('1s_id', $Price['1s_id'])->update([
			'instore' => $price['Количество'],
			'base_unit' => $Unit->id,
		]);
	}

	protected function ech($item)
	{
		echo "{$item->id} - {$item->price}<br>";
	}


}