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

		return $this->template();
	}

	protected function gridTemplate(): void
	{
		foreach ($this->columns as $k => $v) {
			$this->grid .= ' ' . $v['width'] ?? ' 1fr';
//			if (isset($v['concat'])) {
//				$v['concat'] = $this->concatArray($v['concat']);
//
//			}
		}
		$this->grid .= $this->editCol ? ' 50px' : '';
		$this->grid .= $this->delCol ? ' 50px' : '';
	}

	protected function concatArray(array $column, array $model): string
	{
		foreach ($column['concat'] as $v){
		$initValue = '';
			$initValue .= $model[$v].' ';
		}
		return trim($initValue);
	}

//	protected function edit()
//	{
//
/*		return "<th class='edit'><?i nclude EDIT?></th>";*/
//	}
//
//	protected function del()
//	{
//		ob_start();
//		include TRASH;
//		$svg = ob_get_contents();
//		return "<th class='del'>{$svg}</th>";
//	}

	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/CustomList/CustomListTemplate.php';
		$t = ob_get_contents();
		return $t;
	}

}