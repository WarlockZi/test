<?php


namespace app\view\components\Builders\SelectBuilder;


use app\core\FS;
use app\view\components\Traits\CleanString;

class SelectNewBuilder
{
    use CleanString;
	private string $options;
	private string $class;
	private FS $fs;

	public static function build(string $options)
	{
		$select = new static();
		$select->class = '';

        $select->fs = new FS(__DIR__);
        $select->options = $options;

		return $select;
	}

	public function class(string $class)
	{
		$this->class =$class;
		return $this;
	}

	public function get()
	{
        $data = get_object_vars($this);
		return $this->clean($this->fs->getContent('templates/SelectNewBuilderTemplate',$data));
	}

}