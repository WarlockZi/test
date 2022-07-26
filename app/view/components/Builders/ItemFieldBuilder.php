<?php


namespace app\view\components\Builders;


class ItemFieldBuilder
{

	private $field='';
	private $class='';
	private $name='';
	private $type='string';
	private $html='';

	private $hidden='';
	private $required='';
	private $contenteditable='';

	public static function build(string $fieldName)
	{
		$field = new static();
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

	public function html(string $html)
	{
		$this->html = $html;
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
		return
		[
			'field' => $this->field,
			'class' => $this->class,
			'name' => $this->name?$this->name:$this->field,
			'type' => $this->type,
			'hidden' => $this->hidden,
			'required' => $this->required,
			'contenteditable' => $this->contenteditable,
			'html' => $this->html,
		];
	}



}