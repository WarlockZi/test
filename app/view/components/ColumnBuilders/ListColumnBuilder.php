<?php


namespace app\view\components\ColumnBuilders;


class ListColumnBuilder
{

	private $field='id';
	private $class='';
	private $name='';
	private $type='string';
	private $sort=false;
	private $search=false;
	private $width='auto';
	private $hidden=false;
	private $contenteditable=false;

	public static function build(string $field)
	{
		$column = new static();
		$column->field = $field;
		return $column;
	}

	public function class(string $class)
	{
		$this->class = $class;
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
	public function sort(string $sort)
	{
		$this->sort = $sort;
		return $this;
	}
	public function search(string $search)
	{
		$this->search = $search;
		return $this;
	}
	public function width(string $width)
	{
		$this->width = $width;
		return $this;
	}
	public function hidden(string $hidden)
	{
		$this->hidden = $hidden;
		return $this;
	}
	public function contenteditable(bool $contenteditable)
	{
		$this->contenteditable = $contenteditable;
		return $this;
	}
	public function get()
	{
		return
		[
			'field' => $this->field,
			'class' => $this->class,
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