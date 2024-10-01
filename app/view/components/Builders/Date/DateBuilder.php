<?php


namespace app\view\components\Builders\Date;


use app\core\FS;
use app\view\components\Builders\Builder;

class DateBuilder extends Builder
{

	public FS $fs;
	public string $class = '';
	public string $model = '';
	public string $field = '';
	public string $value;
	public string $day = '';
	public string $month = '';
	public string $year = '';
	public string $min = "min='1965-01-01'";
	public string $max = "max='2030-01-01'";
	public string $format = 'yy-mm-dd';

	public static function build($data)
	{
		$self = new self();
        $self->fs = new FS(__DIR__);
		$value = date('Y-m-d', strtotime(time()));
        $self->value = "value='{$value}'" ;
		return $self;
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
		$date = $this;
		return FS::getFileContent(ROOT . '/app/view/components/Builders/Date/Date.php',compact('date'));
	}

}