<?php


namespace app\view\Builders;


use app\controller\FS;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MorphBuilder
{

	protected $morphed;
	protected $morph;
	protected $functionString;
	protected $function;
	protected $slug;
	protected $oneOrMany;

	protected $dndToolTip;
	protected $dndContent;

	protected $class;


	protected $function_detach;

	protected $morphPath = ROOT.'/app/view/Morph/';
	protected $template='many_dnd_plus.php';

	public static function build(Model $morphed, string $morph, bool $one, string $relation)
	{
		$self = new static;

		$self->morphed = $morphed;
		$self->morph = $morph;
		$self->oneOrMany = $one ? "data-morph-oneormany='one'" : "data-morph-oneormany='many'";
		$self->function = "data-morph-function ='{$relation}'";
		$self->relation = $relation;

		$self->template = $self->morphPath.$self->template;

		return $self;
	}

	public function template($template)
	{
		$this->morphPath = $this->morphPath.$this->morph.'/';
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

	public function dnd(
		string $template,
		string $class,
		string $appendTo,
		string $toolTip,
		string $content,
		string $path
	)
	{
		$this->dndClass = $class ? "class='{$class}'" : "";
		$this->dndToolTip = $toolTip ? "data-tooltip='{$toolTip}'" : "";
		$this->dndAppendTo = "data-appendto='{$appendTo}'";
		$this->dndContent = $content ? $content : "";
		$this->dndPath = "data-path='{$path}'";

		ob_start();
		include $this->morphPath . $template;
		$this->addAction = ob_get_clean();
		return $this;
	}

//	public function function_detach($function_detach)
//	{
//		$this->function_detach = $function_detach;
//		return $this;
//	}

	public function get()
	{
		ob_start();
		include $this->template;
		return ob_get_clean();
	}
}