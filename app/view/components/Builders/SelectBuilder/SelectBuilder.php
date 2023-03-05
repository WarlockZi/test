<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{

	private $options='';
	private $class;
	private $title;
	private $field;

	private $model;
	private $modelId;

	private $morphFunction;
	private $morphSlug;
	private $morphOneOrMany;
	private $morphDetach;

	private $belongsToModel;
	private $belongsToId;

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

	public function morph(string $morphFunction,
												string $slug = '',
												string $oneOrMany = 'one',
												bool $detach = false)
	{
		$this->morphFunction = "data-morph-function='{$morphFunction}'";
		$this->morphSlug = $slug ? "data-morph-slug='{$slug}'" : "";
		$this->morphOneOrMany = "data-morph-oneOrMany='{$oneOrMany}'";
		$detach = $detach ? 'true' : 'false';
		$this->morphDetach = $detach ? "data-morph-detach='{$detach}'" : "";
		return $this;
	}

	public function belongsTo(string $model, int $id)
	{
		$this->belongsToModel = "data-belongsTo-model='{$model}'";
		$this->belongsToId = "data-belongsTo-id='{$id}'";
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