<?php


namespace app\view\components\Builders\Morph;


use Illuminate\Database\Eloquent\Model;

class MorphBuilder
{

	protected $morphed;
	protected $morph;
	protected $items = [];

	protected $oneOrMany;
	protected $slug;
	protected $relation;

	protected $class;
	protected $detach;

	protected $morphPath = ROOT . '/app/view/components/Builders/Morph/';
	protected $template = 'many.php';

	public static function build(Model $morphed,
															 string $morph,
															 string $slug,
															 string $relation)
	{
		$self = new static;

		$self->morph = $morph;
		$self->morphed = $morphed;
		$self->items = $morphed[$relation] ?? [];

		$self->oneOrMany = "data-morph-oneormany='one'";
		$self->relation = "data-morph-relation ='{$relation}'";
		$self->slug = "data-morph-slug={$slug}";

		$self->template = $self->morphPath . $self->template;

		return $self;
	}

	public function template($template)
	{
		$this->template = $this->morphPath . $template;
		return $this;
	}

	public function class(string $class)
	{
		$this->class = "class ='{$class}'";
		return $this;
	}

	public function detach(string $class)
	{
		$this->detachClass = $class ? "class='{$class}'" : "";
		$this->detach = $this->morphPath . 'detach.php';

		return $this;
	}

	public function content(string $content)
	{
		$this->content = $content;
		return $this;
	}
	public function many()
	{
		$this->oneOrMany = "data-morph-oneormany='many'";
		return $this;
	}

	protected function getDetach(Model $item)
	{
		ob_start();
		include $this->detach;
		return ob_get_clean();
	}

	public function get()
	{
		ob_start();
		include $this->template;
		return ob_get_clean();
	}

}