<?php


namespace app\view\components\Builders\Morph;


use app\core\FS;
use Illuminate\Database\Eloquent\Model;

class MorphBuilder
{

	protected $morphed;
	protected $morph;
	protected $items;

	protected $detach;

	protected $template = ROOT . '/app/view/components/Builders/Morph/many.php';

	public $relation;
	public $oneOrMany = "data-morph-oneormany='one'";
	public $slug;

	public $class;
	public $html;


	public static function build(Model $morphed,
															 string $relation,
															 string $slug,
															 bool $many = false)
	{
		$self = new static;

		$self->morphed = $morphed;
		$self->items = $morphed[$relation];

		$self->relation = "data-morph-relation ='{$relation}'";
		$self->slug = "data-morph-slug ='{$slug}'";

		$many ? $self->many() : '';
		return $self;
	}

	public function template(string $template)
	{
		$this->template = $template;
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
		$this->detach = ROOT . '/app/view/components/Builders/Morph/detach.php';

		return $this;
	}

	public function html(string $html):MorphBuilder
	{
		$this->html .= $html;
		$this->items = null;
		return $this;
	}

	public function many()
	{
		$this->oneOrMany = "data-morph-oneormany='many'";
		return $this;
	}


	public function get():string
	{
		$morph = $this;
		return FS::getFileContent($this->template, compact('morph'));
	}

}