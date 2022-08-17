<?php


namespace app\view\components\Builders\ItemBuilder;


use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{

	public $field = '';
	public $datafield = '';
	public $class = '';
	public $name = '';
	public $link = '';
	public $type = 'string';
	public $html = '';

	public $hidden = '';
	public $required = '';
	public $contenteditable = '';

	public static function build(string $fieldName, Model $item)
	{
		$field = new static();
		$field->datafield = "data-field={$fieldName}";
		$field->field = $fieldName;
		return $field;
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

	public function link(string $link)
	{
		$this->link = $link;
		return $this;
	}

	public function html(string $html)
	{
		$this->field = $html;
		return $this;
	}

	public function required()
	{
		$this->required = 'required';
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
		$this->name = $this->name ?$this->name : $this->field;
		return $this;
	}


}