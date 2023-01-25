<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\view\components\Builders\Builder;

class CheckboxBuilder extends Builder
{
	private $field;
	private $checked;
	private $value = null;

	private $inputClass;

	private $for;
	private $label;
	private $id;
	private $labelClass;

//	public $html = '';

	public static function build(string $field,
															 bool $checked = false,
															 string $valueType = 'bool')
	{
		$checkbox = new self();
		$checkbox->field = "data-field='{$field}'";


		$checkbox->checked = $checked ? "checked" : '';
		if ($valueType  === 'bool') {
			$value = $checked ? 'true' : 'false';
			$checkbox->value = "data-value='{$value}'";
		} elseif ($valueType  === 'int') {
			$value = $checked ? 1 : 0;
			$checkbox->value = "data-value={$value}";
		} elseif ($valueType  === 'string') {
			$value = $checked ? 'yes' : 'no';
			$checkbox->value = "data-value='{$value}'";
		}

		return $checkbox;
	}

	public function inputClass(string $class)
	{
		$this->inputClass = "class ='{$class}'";
		return $this;
	}

	public function label(string $class, string $label)
	{
		$this->labelClass = "class ='{$class}'";
		$this->label = $label;

		$this->for = $this->field;
		$this->id = $this->field;

		return $this;
	}

	public function get()
	{
		if ($this->label) {
			ob_start();
			include ROOT . '/app/view/components/Builders/CheckboxBuilder/LabelCheckboxTemplate.php';
			return ob_get_clean();
		} else {
			ob_start();
			include ROOT . '/app/view/components/Builders/CheckboxBuilder/CheckboxTemplate.php';
			return ob_get_clean();
		}
	}

}