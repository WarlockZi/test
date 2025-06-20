<?php

namespace app\view\layouts\Admin;


use app\service\AdminSidebar\AdminSidebar;


class AdminLayout
{
    public function __construct(
        public AdminSidebar  $sidebar,
    )
    {
    }

}