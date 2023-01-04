<?php


namespace app\view\components\Builders\ListBuilder;


use app\view\components\Builders\SelectBuilder\ListSelectBuilder;

class ListColumnBuilder
{

	public $field = 'id';
	public $dataField;
	public $class = '';
	public $name = '';
	public $type;
	public $sort = '';
	public $sortIcon = '';
	public $search = '';
	public $width = 'auto';
	public $hidden = '';
	public $contenteditable = '';
	public $link = false;
	public $html = '';
	public $function = '';
	public $functionClass = '';

	public $select = false;
	public $nameOptionByField;
	public $initialOption = '';
	public $initialOptionValue = 0;

	public static function build(string $field)
	{
		$column = new static();
		$column->field = $field;
		$column->dataField = "data-field='{$field}'";
		return $column;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}

	public function select(
		string $modelName,
		string $nameOptionByField='name',
		bool $tree = false,
		string $initialOption = '',
		int $initialOptionValue = 0
	)
	{
		$this->select = true;
		$this->nameOptionByField = $nameOptionByField;
		$this->initialOption = $initialOption;
		$this->initialOptionValue = $initialOptionValue;

		$items = $modelName::all();
		$this->select = ListSelectBuilder::build()
			->collection($items)
			->initialOption('',0)
		;
		return $this;
	}



	public function name(string $name)
	{
		$this->name = $name;
		return $this;
	}

	public function type(string $type)
	{
		$this->type = "data-type='{$type}'";
		return $this;
	}

	public function sort()
	{
		$this->sort = 'data-sort';
		$this->sortIcon = '<div class="icon"></div>';
		return $this;
	}

	public function html($html)
	{
		$this->html = $html;
		return $this;
	}

	public function search(): self
	{
		$this->search = '<input type="text">';
		return $this;
	}

	public function function (string $class, string $function): self
	{
		$this->functionClass = $class;
		$this->function = $function;
		return $this;
	}

	public function width(string $width): self
	{
		$this->width = $width;
		return $this;
	}

	public function hidden()
	{
		$this->hidden = 'hidden';
		return $this;
	}

	public function contenteditable(): self
	{
		$this->contenteditable = 'contenteditable';
		return $this;
	}

	public function get(): self
	{
		$this->name = $this->name ? $this->name : $this->field;
		return $this;
	}

}