<?php

namespace app\Services\XMLParser;



use app\model\Price;

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

  protected function fillGood($price)
  {
    $g['1s_id'] = $price['Ид'];
    $g['1s_art'] = $price['Артикул'];


    $g['unit'] = $price['БазоваяЕдиница']['@attributes']['НаименованиеПолное'];
    $g['unit_code'] = $price['БазоваяЕдиница']['@attributes']['Код'];

    $g['currency'] = $price['Цены']['Цена']['Валюта'];
    $g['price'] = $price['Цены']['Цена']['ЦенаЗаЕдиницу'];

//    $g['category_id'] = $cat->id;
    $p = Price::create($g);

    $this->ech($p);

  }

  protected function ech( $item)
  {
    echo "{$item->id} - {$item->price}<br>";
  }


}