<?php


namespace app\view\components\CustomList;


class CustomList
{
	private $model = [];
	private $tableClassName = '';
	private $columns = [];
	private $searchStr = ' <input type="text">';
	private $editCol = false;
	private $delCol = false;
	private $grid = 'grid-template-columns:';
	private $template = '';
	private $header = '';


	public function __construct($options)
	{
		$this->getOptions($options);
		$this->run();

	}

	protected function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	protected function run()
	{

		$this->gridTemplate();
//		$this->head();

		return $this->template();
	}

	protected function gridTemplate(): void
	{
		foreach ($this->columns as $k => $v) {
			$this->grid .= ' ' . $v['width'] ?? ' 1fr';
		}
		$this->grid .= $this->editCol ? ' 50px' : '';
		$this->grid .= $this->delCol ? ' 50px' : '';
	}

//	protected function head()
//	{
//		ob_start();
//		return ob_get_contents();
//	}
	protected function edit()
	{
//		ob_start();
//		include EDIT;
//		$svg = ob_get_contents();
		return "<th class='edit'><?include EDIT?></th>";
	}
	protected function del()
	{
		ob_start();
		include TRASH;
		$svg = ob_get_contents();
		return "<th class='del'>{$svg}</th>";
	}
	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/CustomList/template.php';
		$t= ob_get_contents();
		return $t;
	}

}