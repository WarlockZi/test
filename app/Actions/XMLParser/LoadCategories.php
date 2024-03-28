<?php

namespace app\Actions\XMLParser;


use app\model\Category;
use app\Services\Logger\ILogger;
use app\Services\Slug;

class LoadCategories extends Parser
{
	protected $logger;

	public function __construct($file, ILogger $logger)
	{
		parent::__construct($file);
		$this->logger = $logger;
		$this->logger->write('--- category start ---' . $this->now());
		$this->run();
		$this->logger->write('--- category  stop ---' . $this->now());
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
		$item['deleted_at'] = NULL;

		$updated = Category::withTrashed()
			->updateOrCreate(['1s_id' => $item['1s_id']], $item);
		return $item;
	}

	protected function ech(array $item)
	{
		echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
	}


}