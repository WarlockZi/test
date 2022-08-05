<?php


namespace app\view\components\Builders\MultiSelectBuilder;


use app\view\components\Builders\Builder;

class MultiSelectBuilder extends Builder
{
	private $items = [];
	private $class = '';
	private $field = '';
	private $title = '';
	private $tab = '.';
	private $optionName = 'name';
	private $initialOption = false;
	private $initialOptionValue = 0;
	private $initialOptionLabel = '-';
	private $selected = [];
	private $excluded = [];

	public static function build(array $items)
	{
		$multiselect = new self();
		$multiselect->items = $items;
		return $multiselect;
	}


	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}

	public function model(string $model)
	{
		$this->model = "data-model='{$model}'";
		return $this;
	}

	public function field(string $field)
	{
		$this->field = "data-field='{$field}'";
		return $this;
	}

	public function title(string $title)
	{
		$this->title = "title='{$title}'";
		return $this;
	}

	public function tab(string $tab)
	{
		$this->tab = $tab;
		return $this;
	}

	public function optionName(string $optionName)
	{
		$this->optionName = $optionName;
		return $this;
	}

	public function initialOption(string $initialOptionValue, string $initialOptionLabel)
	{
		$this->initialOption = true;
		$this->initialOptionValue = $initialOptionValue;
		$this->initialOptionLabel = $initialOptionLabel;
		return $this;
	}

	public function selected($selected = [])
	{
		if (is_array($selected)) {
			$this->selected = $selected;
		}else{
			$this->selected[] = $selected;
		}
		return $this;
	}

	public function excluded($excluded = [])
	{
		if (is_array($excluded)) {
			$this->excluded = $excluded;
		}else{
			$this->excluded[] = $excluded;
		}
		return $this;
	}

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/MultiSelectBuilder/MultiSelectTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}




//	public function getChilds($tree,$level)
//	{
//		$str = '';
//		foreach ($tree as $id => $item) {
//			$str .= $this->getOption($item,$level+1);
//		}
//		return $str;
//	}
//
//	public function getOption($item,$level)
//	{
//		ob_start();
//		require $this->tpl;
//		return ob_get_clean();
//	}
//
//
//	public function run()
//	{
//		ob_start();
//		include ROOT . '/app/view/components/CustomMultiSelect/CustomMultiSelectTemplate.php';
//		$html = ob_get_clean();
//		$this->html = $html;
//	}


}