<?php

namespace app\blade\views\admin\product;
class DndBuilder
{
    public string $path;
    public string $class;
    public string $tooltip;
    public array $img;

    public function __construct()
    {
    }

    public static function make(string $path,
                                string $class = '',
                                string $tooltip = '',
                                array  $img = [],
    ): self
    {
        $dnd          = new static();
        $dnd->path    = "data-path='{$path}'";
        $dnd->class   = "class ='{$class}'";
        $dnd->tooltip = $tooltip;
        $dnd->img     = $img;
        return $dnd;
    }
}