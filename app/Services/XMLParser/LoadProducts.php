<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\model\Product;
use app\Services\Logger\ILogger;
use app\Services\Slug;

class LoadProducts extends Parser
{
	protected $goods;
	protected $type;

	public function __construct($file, $type)
	{
		parent::__construct($file);
		$this->type = $type;
		$this->goods = $this->xmlObj['Каталог']['Товары']['Товар'];
		if ($this->logger)
			$this->logger->write('--- products start ---'.$this->now());

		$this->run();
		if ($this->logger)
			$this->logger->write('--- products stop  ---'.$this->now());
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
		if ($this->type === 'full') {
			$product = $this->fillGood($good, $id);
			$cat = Category::where('1s_id', $product['1s_category_id'])->first();
			$product['category_id'] = $cat->id;
			$p = Product::create($product);
		} else {
			$found = Product::query()
				->where('1s_id', $good['Ид'])
				->first();
			if ($found) {
				$found->delete();
				$product = $this->fillGood($good, $id);
				$cat = Category::where('1s_id', $product['1s_category_id'])->first();
				$product['category_id'] = $cat->id;
				$prod = Product::create($product);
			}
		}
	}

	protected function fillGood($good, $id)
	{
		$g['1s_id'] = $good['Ид'];
		$g['1s_category_id'] = $good['Группы']['Ид'];
		$g['art'] = $good['Артикул']? trim($good['Артикул']):'';
		$g['name'] = $good['Наименование'];
		$g['slug'] = Slug::slug($g['name']);
		if (Product::where('slug', $g['slug'])->first()) {
			$g['slug'] = $g['slug'] . '_' . Slug::slug($g['art']);
		}
		$g['txt'] = $good['Описание'] ? preg_replace('/\n/', '<br>', $good['Описание']) : '';

		foreach ($good['ЗначенияРеквизитов']['ЗначениеРеквизита'] as $requisite) {
			if ($requisite['Наименование'] === 'Полное наименование') {
				$g['full_name'] = $requisite['Значение'];
			}
		}
		return $g;


//			$this->ech($g,$id);
//		}else{
//			$this->ech($g,$id,'same slug'.$g['slug']);
//		}
	}

	protected function ech($item, $id, $sameSlug = '')
	{
		echo "{$id}  - {$sameSlug} {$item['name']}<br>";
	}


}