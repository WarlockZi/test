<?php


namespace app\view\components\Builders\Dnd;


use app\core\FS;
use app\view\components\Traits\CleanString;

class DndBuilder
{
    use CleanString;
	public $path;
	public $class;
	public $tooltip;
	public $wrapClass;

	public static function make(string $path, string $class = '', string $tooltip = '',string $wrapClass='')
	{
		$dnd = new static();
		$dnd->path = "data-path='{$path}'";
		$dnd->class = "class ='{$class}'";
		$dnd->tooltip = $tooltip;

		$result = FS::getFileContent(ROOT . '/app/view/components/Builders/Dnd/template.php', compact('dnd'));
		return $dnd->clean($result);
	}


}

