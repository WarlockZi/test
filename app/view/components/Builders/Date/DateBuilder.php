<?php


namespace app\view\components\Builders\Date;


use app\core\FS;
//use app\view\components\Builders\Builder;

class DateBuilder
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

	public static function build(string|null $date): DateBuilder
    {
		$self = new self();
        $self->fs = new FS(__DIR__);

		$value = date('Y-m-d', strtotime($date??''));
        $self->value = "value='{$value}'" ;
		return $self;
	}

	public function field($field): static
    {
		$this->field = "data-field='{$field}'";
		return $this;
	}
	public function model($model): static
    {
		$this->model = "data-model='{$model}'";
		return $this;
	}

	public function class($class): static
    {
		$this->class = "class='{$class}'";
		return $this;
	}

	public function min($min): static
    {
		$this->min = "min='{$min}'";
		return $this;
	}

	public function max($max): static
    {
		$this->max = "max='{$max}'";
		return $this;
	}

	public function format($format): static
    {
		$this->format = $format;
		return $this;
	}

	public function day($day): static
    {
		$this->day = $day;
		return $this;
	}

	public function month($month): static
    {
		$this->month = $month;
		return $this;
	}

	public function year($year): static
    {
		$this->year = $year;
		return $this;
	}

	public function get(): string
    {
		$date = $this;
		return FS::getFileContent(ROOT . '/app/view/components/Builders/Date/Date.php',compact('date'));
	}

}