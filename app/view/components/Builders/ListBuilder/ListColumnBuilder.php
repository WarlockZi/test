<?php


namespace app\view\components\Builders\ListBuilder;


class ListColumnBuilder
{

	public $field='id';
	public $dataField='id';
	public $class='';
	public $name='';
	public $type="data-type='string'";
	public $sort='';
	public $sortIcon='';
	public $search='';
	public $width='auto';
	public $hidden='';
	public $contenteditable='';
	public $link=false;

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
	public function search()
	{
		$this->search = '<input type="text">';
		return $this;
	}
	public function width(string $width)
	{
		$this->width = $width;
		return $this;
	}
	public function hidden()
	{
		$this->hidden = 'hidden';
		return $this;
	}
	public function contenteditable()
	{
		$this->contenteditable = 'contenteditable';
		return $this;
	}
	public function get()
	{
		return $this;
	}

}