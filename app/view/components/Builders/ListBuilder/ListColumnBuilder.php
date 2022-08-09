<?php


namespace app\view\components\Builders\ListBuilder;


class ListColumnBuilder
{

	private $field='id';
	private $dataField='id';
	private $class='';
	private $name='';
	private $type='string';
	private $sort='';
	private $search='';
	private $width='auto';
	private $hidden='';
	private $link=false;
	private $contenteditable='';

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
		$this->type = $type;
		return $this;
	}
	public function sort()
	{
		$this->sort = 'data-sort';
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
		return
		[
			'field' => $this->field,
			'dataField' => $this->dataField,
			'class' => $this->class,
			'link' => $this->link,
			'name' => $this->name?$this->name:$this->field,
			'type' => $this->type,
			'sort' => $this->sort,
			'search' => $this->search,
			'width' => $this->width,
			'hidden' => $this->hidden,
			'contenteditable' => $this->contenteditable
		];
	}




}