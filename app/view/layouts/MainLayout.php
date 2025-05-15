<?php

namespace app\view\layouts;

use app\action\ViteAction;
use app\view\components\Footer\UserFooter;

class MainLayout extends Layout
{
    public function __construct(
        protected UserFooter $footer,
        protected ViteAction $action,
    )
    {
        parent::__construct($this->action);
    }


    public function footer(): string
    {
        return $this->footer->getFooter();
    }

}
