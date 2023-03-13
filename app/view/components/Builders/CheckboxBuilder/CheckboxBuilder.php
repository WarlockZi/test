<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\core\FS;
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
															 bool $checked)
	{
		$checkbox = new self();
		$checkbox->field = "data-field='{$field}'";
		$checkbox->checked = $checked ? "checked" : '';
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
			return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/LabelCheckboxTemplate.php');
		} else {
			return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/CheckboxTemplate.php');
		}
	}

}