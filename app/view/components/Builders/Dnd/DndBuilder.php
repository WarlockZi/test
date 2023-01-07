<?php


namespace app\view\components\Builders\Dnd;


use app\view\components\Builders\Builder;

class DndBuilder extends Builder
{

	private $belongsToModel;
	private $belongsToId;

	private $morphModel;
	private $morphId;
	private $morphDetach;
	private $morphOneOrMany;

	private $slug;
	private $path;

	private $class;

	public static function build(string $slug, string $path)
	{
		$dnd = new static();
		$dnd->slug = $slug;
		$dnd->path = $path;

		return $dnd;
	}

	public function morph(
		string $morphModel,
		int $morphId,
		bool $morphDetach,
		string $morphOneOrMany
	)
	{
		$this->morphModel = $morphModel;
		$this->morphId = $morphId;
		$this->morphDetach = $morphDetach;
		$this->morphOneOrMany = $morphOneOrMany;

		return $this;
	}

	public function belongsTo(
		string $belongsToModel,
		int $belongsToId
	)
	{
		$this->belongsToModel = $belongsToModel;
		$this->belongsToId = $belongsToId;
		return $this;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}


	public function title(string $title)
	{
		$this->title = "title='{$title}'";
		return $this;
	}


	public function get()
	{
		if ($this->tree) {
			$this->options = TreeBuilder::build($this->tree)->get();
		} else {
			$this->options = $this->getArray();
		}

		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}

		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

}