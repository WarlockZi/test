<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\core\FS;
use app\view\components\Traits\CleanString;

class CheckboxBuilder
{
    use CleanString;
	public $field;
	public $checked;

	public $class;
	public $id;

	public $for;
	public $label;
	public $labelClass;


	public static function build(string $field, ?bool $checked)
	{
		$checkbox = new self();
		$checkbox->field = "data-field='{$field}'";
		$checkbox->checked = $checked ? "checked" : '';
		return $checkbox;
	}

	public function inputClass(string $class)
	{
		$this->class = "class ='{$class}'";
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
		$box = $this;
		if ($this->label) {
			return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/LabelCheckboxTemplate.php', compact('box'));
		} else {
			return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/CheckboxTemplate.php', compact('box'));
		}
	}

}