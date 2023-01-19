<?php


namespace app\view\components\Builders\SelectBuilder;


use app\controller\AppController;
use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ListSelectBuilder extends Builder
{
	private $tree;
	private $collection;
	private $options;
	private $class;
	private $title;

	private $field;
	private $model;
	private $modelId;

	private $morphFunction;
	private $morphId;
	private $morphSlug;
	private $morphOneOrMany;
	private $morphDetach;

	private $belongsToModel;
	private $belongsToId;

	private $selected = false;
	private $excluded = false;
	private $nameOptionByField = 'name';
	private $initialOption;

	private $tab = '&nbsp;';

	public static function build()
	{
		$select = new static();
		return $select;
	}

	public function collection(Collection $collection)
	{
		$this->collection = $collection;
		return $this;
	}

	public function item(Model $item)
	{
		$model = AppController::shortClassName($item);
		$id = $item->id;
		$this->model = "data-model='{$model}''";
		$this->modelId = "data-model-id='" . $id . "'";
		return $this;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
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

	public function initialOption(string $initialOptionLabel, int $initialOptionValue)
	{
		$this->initialOption =
			"<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
		return $this;
	}

	public function nameOptionByField(string $nameOptionByField)
	{
		$this->nameOptionByField = $nameOptionByField;
		return $this;
	}

	public function selected($selected)
	{
		$this->selected = $selected;
		return $this;
	}

	public function excluded(string $excluded)
	{
		$this->excluded = (int)$excluded;
		return $this;
	}

	public function tab(string $tab)
	{
		$this->tab = $tab;
		return $this;
	}

	private function getOptions()
	{
		$tpl = '';
		foreach ($this->collection as $item) {
			$selected = $this->selected === $item->id ? 'selected' : '';
			$tpl .= "<option value='{$item['id']}' $selected>{$item['name']}</option>";
		}
		return $tpl;
	}

	public function getEmpty()
	{
		$this->selected = 0;
		$this->options = $this->getOptions();

		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}

		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

	public function get(int $id = 0)
	{
		$this->options = $this->getOptions();

		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}

		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $result;
	}

}