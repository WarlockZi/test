<?php


namespace app\view\components\Builders\Dnd;


use app\service\FS;
use app\view\components\Traits\CleanString;

class DndBuilder
{
    use CleanString;

    public string$path;
    public string $class;
    public string $tooltip;

    public static function make(string $path, string $class = '', string $tooltip = '')
    {
        $dnd          = new static();
        $dnd->path    = "data-path='{$path}'";
        $dnd->class   = "class ='{$class}'";
        $dnd->tooltip = $tooltip;

        $result = FS::getFileContent(ROOT . '/app/view/components/Builders/Dnd/index.php', compact('dnd'));
        return $dnd->clean($result);
    }
}