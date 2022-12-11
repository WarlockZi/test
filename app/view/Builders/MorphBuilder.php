<?php


namespace app\view\Builders;


use app\controller\FS;
use Illuminate\Database\Eloquent\Model;

class MorphBuilder
{
	protected $one;
	protected $many;
	protected $morphed;
	protected $morph;
	protected $slug;

	protected $dndClass;
	protected $dndToolTip;
	protected $dndContent;

	protected $function_sync;
	protected $function_sync_without_detaching;
	protected $function_del;
	protected $function_detach;
	protected $template;
	protected $morphPath = '';

	public static function build(Model $morphed, string $morph, string $slug)
	{
		$self = new static;
		$self->morphed = $morphed;
		$self->morph = $morph;
		$self->slug = "data-slug='{$slug}'";
		$self->morphPath = FS::platformSlashes(
			FS::getPath('app', 'view', $self->morph, 'morph')
		);
		return $self;
	}

	public function one($one)
	{
		$this->one = $one;
		return $this;
	}

//	public function addAction(string $template): self
//	{
//		ob_start();
//		include $this->morphPath . $template;
//		$this->addAction = ob_get_clean();
//		return $this;
//	}

	public function many($many)
	{
		$this->many = $many->all();
		return $this;
	}

	public function detach(string $class, string $slug)
	{
		$this->detachClass = $class ? "class='{$class}'" : "";
		$this->detachSlug = $slug ? "data-slug='{$slug}'" : "";
		$this->detach = $this->morphPath . 'detach.php';
		return $this;
	}

	public function dnd(
		string $action,
		string $template,
		string $class,
		string $appendTo,
		string $toolTip,
		string $content)
	{
		$this->dndAction = $action ? "data-dnd='{$action}'" : "";
		$this->dndClass = $class ? "class='{$class}'" : "";
//		$this->dndSlug = $slug ? "data-slug='{$slug}'" : "";
		$this->dndToolTip = $toolTip ? "data-tooltip='{$toolTip}'" : "";
		$this->dndAppendTo = "data-appendto='{$appendTo}'";
		$this->dndContent = $content ? $content : "";

		ob_start();
		include $this->morphPath . $template;
		$this->addAction = ob_get_clean();
		return $this;
	}

	public function template($template)
	{
		$this->template = $this->morphPath . $template;
		return $this;
	}

	public function function_sync($function_sync)
	{
		$this->function_sync = $function_sync;
		return $this;
	}

	public function function_sync_without_detaching($function_sync_without_detaching)
	{
		$this->function_sync_without_detaching = $function_sync_without_detaching;
		return $this;
	}

	public function function_del($function_del)
	{
		$this->function_del = $function_del;
		return $this;
	}

	public function function_detach($function_detach)
	{
		$this->function_detach = $function_detach;
		return $this;
	}

	public function get()
	{
		ob_start();
		include $this->template;
		return ob_get_clean();
	}
}