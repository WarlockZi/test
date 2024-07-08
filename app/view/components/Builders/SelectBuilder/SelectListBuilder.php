<?php


namespace app\view\components\Builders\SelectBuilder;

use app\core\FS;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use app\view\components\Traits\CleanString;

class SelectListBuilder
{
    use CleanString;
	private array $tree;
	private string $options;
	private string $class;
	private string $title;
	private string $field;
	private string $model;
	private string $modelId;

	private bool $selected = false;
	private bool $excluded = false;
	private string $nameOptionByField;
	private string $initialOption='';
	private string $tab;
	private FS $fs;
	private Collection $collection;

	public static function build()
	{
		$select = new static();
		$select->selected = false;
		$select->excluded = false;
		$select->class = '';
		$select->initialOption = 'name';
		$select->tab = '&nbsp;';
		$select->title = '';
		$select->fs = new FS(__DIR__);

		return $select;
	}

	public function collection(Collection $collection):SelectListBuilder
	{
		$this->collection = $collection;
		return $this;
	}
	public function item(Model $item):SelectListBuilder
	{
        $model = $this->getShortName($item);
		$id = $item->id;
		$this->model = "data-model='{$model}''";
		$this->modelId = "data-model-id='" . $id . "'";
		return $this;
	}

    protected function getShortName(Model $model):string
    {
        $reflection = new \ReflectionClass($model);
        return lcfirst($reflection->getShortName());
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
		return $this->initialOption.$tpl;
	}

	public function getEmpty()
	{
		$this->selected = 0;
		$this->options = $this->getOptions();

		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}
		return $this->fs->getContent("SelectBuilderTemplate");
	}

	public function get(int $id = 0)
	{
		$this->options = $this->getOptions();
		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}
        $data = get_object_vars($this);
		return $this->fs->getContent('SelectBuilderTemplate',$data);
	}

}