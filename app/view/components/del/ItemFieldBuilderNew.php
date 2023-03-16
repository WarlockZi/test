<?php


namespace app\view\components\Builders\ItemBuilder;


use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilderNew
{

	protected $field;
	protected $item;

	protected $class;
	protected $name;

	protected $value;
	protected $hidden;
	protected $required;
	protected $contenteditable;

	protected $html;

	public static function build(string $field, Model $item)
	{
		$field = new static();
		$field->field = "data-field={$field}";
//		$field->field = $fieldName;
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
		$this->setValue();

		return $this;
	}

	protected function setValue(): void
	{
		$this->value = $this->item[$this->field];
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