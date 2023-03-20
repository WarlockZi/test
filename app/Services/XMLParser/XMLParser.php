<?php


namespace app\Services\XMLParser;


use app\core\FS;

class XMLParser
{
	protected $file;

	public function __construct(string $file)
	{
		$this->file = FS::platformSlashes(ROOT . '/app/Services/XMLParser/' . $file . '.xml');
		$this->run();
	}

	protected function run()
	{
		$content = simplexml_load_file($this->file);
		$groups = $content->Классификатор->Группы;
		$groups = json_decode(json_encode($groups), true)['Группа'];
//		$arr = $this->go($groups);
		$tree = [];
		$items = [];
		$arr = $this->tree($groups, $tree, $items);
		$goods = $content->Классификатор->Группы;
	}

	protected function tree($groups, &$tree, &$items)
	{
		$parent = "Группы";
		foreach ($groups as $id => &$node) {
			$curr = $this->fillCurrent($node, $id);
			if ((isset($node[$parent]) && !(bool)$node[$parent]) || $node[$parent] == null) {
				if (count($node) > 1)
					$tree[$id] = &$node;
			} elseif (isset($node[$parent]) && $node[$parent]) {
				$items[(int)$node[$parent]]['childs'][$id] = &$node;
			}
		}
	}


	protected function fillCurrent(array $groups, $id, $category_id)
	{
		if (isset($groups['Группы'])) unset($groups['Группы']);
		foreach ($groups as $k => $v) {
			$curr[$k] = $v;
		}
		$curr['id'] = $id;
		$curr['category_id'] = $category_id;
		return $curr;
	}

	protected function push(array &$parent, array &$arr, array &$curr)
	{
		if (!$parent) {
			array_push($arr, $curr);
		} else {
			$parent['child'] = $curr;
		}
	}


	protected function go($groups, $level = 0, array &$arr = [], &$parent = [], $id = 0)
	{
		$level++;
		if ($this->isAssoc($groups)) {
			$id++;
			$curr = $this->fillCurrent($groups, $id, $parent['id']);
			$this->push($parent, $arr, $curr);
		} else {
			foreach ($groups as $i => $group) {
				$id++;
				$curr = $this->fillCurrent($group, $id, $parent['id']);
				$this->push($parent, $arr, $curr);
				if (isset($group['Группы']))
					$this->go($group['Группы']['Группа'], $level, $arr, $curr, $id);
			}
		}
		return $arr;
	}

	protected function recursion($groups, $level = 0, array $arr = [], &$parent = [], $id = 0)
	{

	}

	protected function isAssoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

}