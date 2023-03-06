<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{

	private $options='';
	private $class;
	private $title;
	private $field;

	private $relation;

	private $initialOption;

	public static function build(string $options)
	{
		$select = new static();
		$select->options = $options;

		return $select;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}


	public function relation(string $relation)
	{
		$this->relation = "data-relation='{$relation}'";
		return $this;
	}

	public function field(string $field)
	{
		$this->field = "data-field='{$field}'";
		return $this;
	}

	public function title(string $title)
	{
		$this->title = "title='{$title}'";
		return $this;
	}

	public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0)
	{
		$this->initialOption =
			"<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
		return $this;
	}

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

}