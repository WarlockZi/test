<?php


namespace app\view\components\Builders\ItemBuilder;

use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemBuilder extends Builder
{
	private $model = '';
	private $id = 0;
	private $item = [];

	private $pageTitle = '';
	private $class = '';
	private $href = '';
	private $del = false;
	private $save = false;
	public $toList = false;

	private $fields = [];
	private $tabs = [];

	public $html = '';

	public static function build(Model $item, string $model)
	{
		$view = new static();
		$view->model = "data-model='{$model}'";
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
		$this->pageTitle = $pageTitle??'';
		return $this;
	}

	public function del()
	{
		$this->del = true;
		return $this;
	}

	public function save()
	{
		$this->save = true;
		return $this;
	}

	public function toList(string $href = '')
	{
		$this->toList = true;
		if ($href) {
			$this->href = '/' . $href;
		}
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

}