<?php


namespace app\view\components\MyItem;

class MyItem
{
	private $model = '';
	private $item = [];

	private $class = '';
	private $del = false;
	private $save = false;
	public $toList = false;

	private $fields = [];
	private $tabs = [];

	public $html = '';

	public static function build(string $modelName, $id)
	{
		$view = new static();
		$item = new $modelName;
		$view->model = $item->model;
		$view->item = $item::where("id", '=', $id)->get()[0];
		return $view;
	}

	public function class(string $class)
	{
		$this->class = $class;
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

	public function toList()
	{
		$this->toList = true;
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
		include ROOT . '/app/view/components/MyItem/MyItemTemplate.php';
		return ob_get_clean();
	}



//	protected function getEditButton($model, $field, $column)
//	{
//		include ROOT . '/app/view/components/MyItem/edit.php';
//		return $edit;
//	}
//
//	protected function getDelButton($model, $field, $column)
//	{
//		include ROOT . '/app/view/components/MyItem/del.php';
//		return $del;
//
//	}


}