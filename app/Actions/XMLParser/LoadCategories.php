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
		try {
			$item['id'] = $id;
			$item['1s_id'] = $group['Ид'];
			$item['category_id'] = ($level > 0 && isset($parent['id'])) ? $parent['id'] : NULL;
			$item['show_front'] = $level === 1 ? 1 : NULL;

			$item['name'] = $group['Наименование'];
			$item['slug'] = Slug::slug($item['name']);
			$item['deleted_at'] = NULL;

			$updated = Category::withTrashed()
				->updateOrCreate(['1s_id' => $item['1s_id']], $item);
			$this->logger->write('--- category  load ---' . $this->now() . implode(',', $item) .' -- u --'.implode('**',$updated). PHP_EOL);

			return $item;
		} catch (\Exception $e) {
			$this->logger->write('--- category  error ---' . $this->now() . $e->getMessage());
		}

	}

	protected function ech(array $item)
	{
		echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
	}


}