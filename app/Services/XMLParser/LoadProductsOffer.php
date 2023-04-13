<?php

namespace app\Services\XMLParser;


use app\model\Product;

class LoadProductsOffer extends Parser
{
	protected $goods;

	public function __construct($file)
	{
		parent::__construct($file);
		$this->goods = $this->xmlObj['ПакетПредложений']['Предложения']['Предложение'];
		$this->run();
	}

	protected function run()
	{
		$id = 0;
		foreach ($this->goods as $good) {
			$this->fillGood($good,$id++);
		}
	}

	protected function fillGood($good,$id)
	{
		$p = Product::where('1s_id',$good['Ид'] )->first();
		if ($p){
			$p->instore = $good['Количество'] ? $good['Количество'] : 0;
			$p->save();
			$this->ech($p,$id);
		}
	}

	protected function ech($item, $id)
	{
		echo "{$id}  колво {$item['instore']}<br>";
	}


}