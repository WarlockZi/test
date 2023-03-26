<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\model\Product;

class LoadProducts extends Parser
{
  protected $goods;

  public function __construct()
  {
    parent::__construct();
    $this->goods = $this->xmlObj['Каталог']['Товары']['Товар'];
    $this->run();
  }

  protected function run()
  {
    foreach ($this->goods as $good) {
      $this->fillGood($good);
    }
  }

  protected function fillGood($good)
  {
    $g['1s'] = $good['Ид'];
    $g['1s_categrory_id'] = $good['Группы']['Ид'];
    $g['art'] = $good['Артикул'];
    $g['name'] = $good['Наименование'];
    $g['txt'] = $good['Описание']?$good['Описание']:'';

    foreach ($good['ЗначенияРеквизитов']['ЗначениеРеквизита'] as $requisite) {
      if ($requisite['Наименование']==='Полное наименование'){
        $g['full_name'] = $requisite['Значение'];
      }
    }

    $cat = Category::where('1s', $g['1s_categrory_id'])->first();
    $g['category_id'] = $cat->id;
    $p = Product::create($g);

    $this->ech($p);

  }

  protected function ech( $item)
  {
    echo "{$item->id} - {$item->name}<br>";
  }


}