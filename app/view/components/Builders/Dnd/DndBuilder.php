<?php


namespace app\view\components\Builders\Dnd;


use app\view\components\Builders\Builder;

class DndBuilder extends Builder
{
	private $path;
	private $class;
	private $title;

	public static function build(string $path, string $class='', string $tooltip='')
	{
		$dnd = new static();
		$dnd->path = "data-dnd-path='{$path}'";
		$dnd->class = "class ='holder {$class}'";
		$dnd->tooltip = $tooltip;

		return $dnd;
	}

	public function title(string $title)
	{
		$this->title = $title ? "<div class='page-title'>{$title}</div>" : '';
		return $this;
	}

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/Dnd/template.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}






//	private $belongsTo_model;
//	private $belongsTo_id;

//	private $morphed;
//	private $morphed_relation;
//
//	private $morph_model;
//	private $morph_id;
//	private $morph_detach;
//	private $morph_one_or_many;
//	private $morph_slug;
//	private $morph_class;
//	public function morph(
//		Model $morphed,
//		string $morphed_relation,
//		string $morph_model,
//		int $morph_id,
//		bool $morph_detach,
//		string $morph_one_or_many,
//		string $morph_slug,
//		string $morph_class
//	)
//	{
//		$this->morphed = $morphed;
//		$this->morphed_relation = $morphed_relation;
//
//		$this->morph_model = "data-morph-model='{$morph_model}'";
//		$this->morph_id = "data-morph-id='{$morph_id}'";
//		$this->morph_detach = $morph_detach;
//
//		if ($morph_one_or_many = 'one') {
//			$this->morph_one_or_many = "data-morph-oneormany='one'";
//		} else {
//			$this->morph_one_or_many = "data-morph-oneormany='many'";
//		}
//
//		$this->morph_slug = "data-morph-slug='{$morph_slug}'";
//		$this->morph_class = "class='{$morph_class}'";
//
//		return $this;
//	}

//	public function belongsTo(
//		string $belongsTo_model,
//		int $belongsTo_id
//	)
//	{
//		$this->belongsTo_model = $belongsTo_model;
//		$this->belongsTo_id = $belongsTo_id;
//		return $this;
//	}
}

