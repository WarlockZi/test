<?php

namespace app\controller\Admin;

use app\action\admin\RoleAction;
use app\model\Role;

class RoleController extends AdminscController
{
    public function __construct(
        protected RoleAction $actions,
        protected string     $model = Role::class,
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $this->showTable();

    }

}
