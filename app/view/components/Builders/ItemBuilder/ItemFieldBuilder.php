<?php


namespace app\view\components\Builders\ItemBuilder;


use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{
	public $field;
	public $item;
	public $datafield;
	public $class;
	public $name;
//	public $link;

	public $html;

	public $value;
	public $hidden;
	public $required;
	public $contenteditable;

	public static function build(string $fieldName, Model $item)
	{
		$field = new static();
		$field->datafield = "data-field={$fieldName}";
		$field->field = $fieldName;
		$field->item = $item;
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

	public function link(string $link)
	{
		$this->link = $link;
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
		$this->name = $this->name ? $this->name : $this->field;
		$this->value = $this->html ? $this->html : $this->item[$this->field];

		return $this;
	}


	public function toHtml(string $model): string
	{
		$this->dataModel = "data-model={$model}";
		$field = $this;
		ob_start();
		include ROOT . '/app/view/components/Builders/ItemBuilder/row.php';
		return ob_get_clean();

	}


}