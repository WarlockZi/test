<?php

namespace app\view\layouts;

use app\action\ViteAction;

abstract class Layout implements ILayout
{
    public function __construct(
        protected ViteAction $action,
    )
    {
    }

    public function vite(array $assets): string
    {
        return $this->action->getJsCss($assets);
    }
}