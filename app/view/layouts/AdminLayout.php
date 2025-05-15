<?php

namespace app\view\layouts;

use app\action\ViteAction;
use app\service\AdminSidebar\AdminSidebar;


class AdminLayout extends Layout
{
    public function __construct(
        public AdminSidebar  $sidebar,
        protected ViteAction $action,
    )
    {
        parent::__construct($this->action);
    }

}