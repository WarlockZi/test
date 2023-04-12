<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\Services\Slug;

class LoadCategories extends Parser
{
	public function __construct($file)
	{
		parent::__construct($file);
		$this->run();
	}

	protected function run()
	{
		$groups = $this->xmlObj['Классификатор']['Группы']['Группа'];
		$arr = [];
		$id = 0;
		$this->recursion($groups, $id, -1, $arr);
	}

	protected function recursion($groups, &$id, $level = 0, &$parent = null)
	{
		$level++;
		if ($this->isAssoc($groups)) {
			$id++;
			$item = $this->fillItem($groups, $level, $id, $parent);
			$parent[] = &$item;
			if (isset($groups['Группы']))
				$this->recursion($groups['Группы']['Группа'], $id, $level, $item);
		} else {
			foreach ($groups as $i => $group) {
				$this->recursion($group, $id, $level, $parent);
			}
		}
	}

	protected function fillItem(array $group, int $level, int $id, &$parent)
	{
		$item['id'] = $id;
		$item['1s_id'] = $group['Ид'];
		if ($level > 0)
			$item['category_id'] = $parent['id'];
		$item['name'] = $group['Наименование'];
		$item['slug'] = Slug::slug($item['name']);
		$category = Category::create($item);
		$item['pref'] = str_repeat('-', $level);
		$this->ech($item);
		return $item;
	}

	protected function ech(array $item)
	{
//		$cat_id = $item['category_id'] ?? 0;
		echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
	}
}