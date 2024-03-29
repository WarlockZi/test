<?php

namespace app\Actions\XMLParser;


use app\model\Category;
use app\model\Product;
use app\Services\Logger\ILogger;
use app\Services\Slug;

class LoadProducts extends Parser
{
	protected $goods;
	protected $logger;

	public function __construct($file, ILogger $logger)
	{
		parent::__construct($file);
		$this->logger = $logger;
		$this->goods = $this->xmlObj['Каталог']['Товары']['Товар'];
		$this->logger->write('--- products start ---' . $this->now());
		$this->run();
		$this->logger->write('--- products stop  ---' . $this->now());
	}

	protected function run()
	{
		$id = 0;
		foreach ($this->goods as $good) {
			$this->fork($good, $id++);
		}
	}

	protected function fork($good, $id)
	{
		$product = $this->fillGood($good, $id);
		$cat = Category::where('1s_id', $product['1s_category_id'])->first();
		$product['category_id'] = $cat->id;
		$p = Product::create($product);
	}

	protected function fillGood($good, $id)
	{
		$g['1s_id'] = $good['Ид'];
		$g['1s_category_id'] = $good['Группы']['Ид'];
		$g['art'] = $good['Артикул'] ? trim($good['Артикул']) : '';
		$g['name'] = $good['Наименование'];
		$g['print_name'] = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'];
		$g['slug'] = Slug::slug($g['print_name']);
		if (Product::where('slug', $g['slug'])->first()) {
			$g['slug'] = $g['slug'] . '_' . Slug::slug($g['art']);
		}
		$g['txt'] = $good['Описание'] ? preg_replace('/\n/', '<br>', $good['Описание']) : '';

		return $g;

	}

	protected function ech($item, $id, $sameSlug = '')
	{
		echo "{$id}  - {$sameSlug} {$item['name']}<br>";
	}


}