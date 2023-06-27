<?php

namespace app\Services\XMLParser;


use app\model\Category;
use app\Services\Slug;

class LoadCategories extends Parser
{
	protected $type;
	protected $logger;

	public function __construct($file, $type, $logger)
	{
		parent::__construct($file);
		$this->logger = $logger;
		$this->type = $type;
		if ($this->logger) $this->logger->write("---- CATEGORIES ----"."\n");
		$this->run();
	}

	protected function run($arr = [], $id = 0)
	{
		$groups = $this->xmlObj['Классификатор']['Группы']['Группа'];
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
			Category::create($item);
		} else {
			$this->partCreate($item, $level, $parent);
		}
//		if ($this->logger) $this->logger->write(json_encode($item)."\n");

		return $item;
	}

	protected function ech(array $item)
	{
		echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
	}

	protected function partCreate($item, $level, $parent)
	{
		$found = Category::query()
			->where('1s_id', $item['1s_id'])
			->first();
		if ($found) {
			$found->delete();
			if ($level > 0 && isset($parent['id']))
				$item['category_id'] = $parent['id'];
			if ($level === 1) {
				$item['show_front'] = 1;
			}
			Category::create($item);
		}
	}
}