<?php


namespace app\view\components\Builders\Date;


use app\core\FS;
use app\view\components\Builders\Builder;

class DateBuilder extends Builder
{

	public $class = '';
	public $model = '';
	public $field = '';
	public $value = "value='2000-01-01'";
	public $day = '';
	public $month = '';
	public $year = '';
	public $min = "min='1965-01-01'";
	public $max = "max='2030-01-01'";
	public $format = 'yy-mm-dd';

	public static function build($data)
	{
		$date = new self();
		$value = date('Y-m-d', strtotime($data));
		$date->value = "value='{$value}'" ;
		return $date;
	}

	public function field($field)
	{
		$this->field = "data-field='{$field}'";
		return $this;
	}
	public function model($model)
	{
		$this->model = "data-model='{$model}'";
		return $this;
	}

	public function class($class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}

	public function min($min)
	{
		$this->min = "min='{$min}'";
		return $this;
	}

	public function max($max)
	{
		$this->max = "max='{$max}'";
		return $this;
	}

	public function format($format)
	{
		$this->format = $format;
		return $this;
	}

	public function day($day)
	{
		$this->day = $day;
		return $this;
	}

	public function month($month)
	{
		$this->month = $month;
		return $this;
	}

	public function year($year)
	{
		$this->year = $year;
		return $this;
	}

	public function get()
	{
		return FS::getFileContent(ROOT . '/app/view/components/Builders/Date/Date.php');
	}

}