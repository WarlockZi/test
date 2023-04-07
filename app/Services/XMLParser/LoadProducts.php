<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\model\Product;
use app\Services\Slug;

class LoadProducts extends Parser
{
	protected $goods;

	public function __construct($file)
	{
		parent::__construct($file);
		$this->goods = $this->xmlObj['Каталог']['Товары']['Товар'];
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
//    $g['1s_id'] = $good['Ид'];
		$g['1s_categrory_id'] = $good['Группы']['Ид'];
		$g['art'] = $good['Артикул'];
		$g['name'] = $good['Наименование'];
		$g['slug'] = Slug::slug($g['name']);
		if (!Product::where('slug', $g['slug'])->first()) {
			$g['txt'] = $good['Описание'] ? $good['Описание'] : '';
//			$g['instock'] = $good['Количество'] ? $good['Количество'] : 0;

			foreach ($good['ЗначенияРеквизитов']['ЗначениеРеквизита'] as $requisite) {
				if ($requisite['Наименование'] === 'Полное наименование') {
					$g['full_name'] = $requisite['Значение'];
				}
			}

			$cat = Category::where('1s_id', $g['1s_categrory_id'])->first();
			$g['category_id'] = $cat->id;
			$p = Product::create($g);
			$this->ech($g,$id);
		}else{
			$this->ech($g,$id,'same slug'.$g['slug']);
		}
	}

	protected function ech($item, $id,$sameSlug='')
	{
//		$instock = "колво: {$item['Количество']}-";
		echo "{$id}  {$sameSlug} {$item['name']}<br>";
	}


}