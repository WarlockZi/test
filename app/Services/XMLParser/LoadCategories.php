<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\Services\Slug;

class LoadCategories extends Parser
{
	protected $type;

	public function __construct($file, $type)
	{
		parent::__construct($file);
		$this->type = $type;
		$this->run();
	}

	protected function run()
	{
		$groups = $this->xmlObj['Классификатор']['Группы']['Группа'];
		$arr = [];
		$id = 0;
		$this->recursion($groups['Группы']['Группа'], $id, -1, $arr);
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
		if ($level > 0 && isset($parent['id']))
			$item['category_id'] = $parent['id'];
		if ($level === 1) {
			$item['show_front'] = 1;
		}
		$item['name'] = $group['Наименование'];
		$item['slug'] = Slug::slug($item['name']);

		if ($this->type === 'full') {
			$category = Category::create($item);
		} else {
			$found = Category::query()
				->where('1s_id', $item['1s_id'])
				->first();
			if ($found){
				$found->delete();
				if ($level > 0 && isset($parent['id']))
					$item['category_id'] = $parent['id'];
				if ($level === 1) {
					$item['show_front'] = 1;
				}
				$category = Category::create($item);
			}
		}

//		$item['pref'] = str_repeat('-', $level);
//		$this->ech($item);
		return $item;
	}

	protected function ech(array $item)
	{
		echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
	}
}