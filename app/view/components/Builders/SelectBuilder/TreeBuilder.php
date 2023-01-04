<?php


namespace app\view\components\Builders\SelectBuilder;


use Illuminate\Database\Eloquent\Collection;

class TreeBuilder
{

	private $self;
	public $collection;

	public static function build(Collection $collection)
	{
		$self = new self();
		$self->collection = $collection;
		return $self;

	}

	public function get(){
		$level = 0;
		$string = '';
		foreach ($this->collection as $item) {
			$string .= $this->addItem($item, $level);
		}
		return $string;
	}


	private function addItem($item, $level)
	{
		$tab = str_repeat($this->tab, $level);
		$selected = (int)$item['id'] === (int)$this->selected
			? 'selected'
			: '';
		$menu = "<option value='{$item['id']}' {$selected}>{$tab}{$item['name']}</option>";
		if (isset($item['childs'])) {
			$menu .= "{$this->getTree2($item['childs'],$level+1)}";
		}
		return $menu;
	}

	private function getTree($tree, $level = 0, $str = '')
	{
		foreach ($tree as $k => $item) {
			$selected = (int)$this->selected === (int)$item['id'] ? 'selected' : '';
			$tab = str_repeat($this->tab, $level);

			$str .= "<option value='{$item['id']}' $selected>{$tab}{$item[$this->nameOptionByField]}</option>";

			if (isset($item['childs'])) {
				$str .= $this->getChilds($item['childs'], $level + 1, $str);
			}
		}
		return $str;
	}

	protected function getChilds(array $tree, $level, $str)
	{
		foreach ($tree as $id => $item) {
			$selected = (int)$this->selected === (int)$item['id'] ? 'selected' : '';
			$tab = str_repeat($this->tab, $level);
			$str .= "<option value='{$item['id']}' $selected>{$tab}{$item[$this->nameOptionByField]}</option>";

			if (isset($item['childs'])) {
				$str .= $this->getChilds($item['childs'], $level + 1, $str);
			}
		}
		return $str;
	}


}