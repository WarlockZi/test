<?php


namespace app\view\components\Builders\ItemBuilder;

use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemBuilder extends Builder
{
	private $model;
	private $dataModel;
	private $id;
	private $item = [];

	private $pageTitle;
	private $class;
	private $del = false;
	private $softDel = false;
	private $save = false;

	public $toListHref = '';
	public $toList = false;
	public $toListText = 'К списку';

	private $fields = [];
	private $tabs = [];

	public $html = '';

	public static function build(?Model $item, string $model)
	{
		$view = new static();
		$name = $view->getModelName($item->getTable());
		$view->dataModel = "data-model='{$model}'";
		$view->model = $model;
		$view->item = $item->toArray();
		$view->id = "data-id='{$view->item['id']}'";
		return $view;
	}

	public function class(string $class)
	{
		$this->class = $class;
		return $this;
	}

	public function pageTitle(string $pageTitle)
	{
		$this->pageTitle = $pageTitle ?"<div class='page-title'>{$pageTitle}</div>": '';
		return $this;
	}

	public function field($field)
	{
		$this->fields[] = $field;
		return $this;
	}

	public function tab($tab)
	{
		$this->tabs[] = $tab;
		return $this;
	}

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/ItemBuilder/ItemTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

	function getModelName($table)
	{
		return Str::studly(Str::singular($table));
	}

	public function del(bool $isAdmin = true)
	{
		if ($isAdmin) {
			$this->del = true;
		}
		return $this;
	}


	public function softDel()
	{
		$this->del = false;
		$this->softDel = true;
		return $this;
	}

	public function save()
	{
		$this->save = true;
		return $this;
	}

	public function toList(string $href = '', string $text = '', bool $isAdmin = true)
	{
		if ($isAdmin) {
			$this->toList = true;
			if ($href) {
				$this->toListHref = '/' . $href;
			}
			$this->toListText = $text ? $text : $this->toListText;
		}
		return $this;
	}

}