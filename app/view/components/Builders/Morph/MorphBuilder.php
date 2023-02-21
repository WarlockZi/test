<?php


namespace app\view\components\Builders\Morph;


use Illuminate\Database\Eloquent\Model;

class MorphBuilder
{

	protected $morphed;
	protected $morph;
//	protected $functionString;

	protected $oneOrMany;
	protected $slug;

	protected $function;
	protected $relation;
	protected $items=[];

	protected $class;

	protected $dndToolTip;
	protected $dndContent;


	protected $detach;

	protected $morphPath = ROOT . '/app/view/components/Builders/Morph/';
	protected $template = 'many.php';

	public static function build(Model $morphed, string $morph, bool $one, string $relation)
	{
		$self = new static;

		$self->morphed = $morphed;
		$self->morph = $morph;

		$self->oneOrMany = $one ? "data-morph-oneormany='one'" : "data-morph-oneormany='many'";
		$self->function = "data-morph-function ='{$relation}'";
		$self->slug = $relation;

		$self->items = $morphed[$relation]??[];

		$self->template = $self->morphPath . $self->template;

		return $self;
	}

	public function template($template)
	{
		$this->morphPath = $this->morphPath . $this->morph . '/';
		$this->template = $this->morphPath . $template;
		return $this;
	}

	public function slug(string $slug)
	{
		$this->slug = "data-morph-slug={$slug}";
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

	protected function getDetach(Model $item){
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


//
//	public function dnd(
//		string $template,
//		string $class,
//		string $appendTo,
//		string $toolTip,
//		string $content,
//		string $path
//	)
//	{
//		$this->dndClass = $class ? "class='{$class}'" : "";
//		$this->dndToolTip = $toolTip ? "data-tooltip='{$toolTip}'" : "";
//		$this->dndAppendTo = "data-appendto='{$appendTo}'";
//		$this->dndContent = $content ? $content : "";
//		$this->dndPath = "data-path='{$path}'";
//
//		ob_start();
//		include $this->morphPath . $template;
//		$this->addAction = ob_get_clean();
//		return $this;
//	}

}