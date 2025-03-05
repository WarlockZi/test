<?php

namespace app\controller\Admin;

use app\model\Role;
use app\Repository\RolesRepository;
use app\view\Role\RolesView;

class RoleController extends AdminscController
{
    public function __construct(
        protected string          $model = Role::class,
        protected RolesRepository $repo = new RolesRepository,
        protected RolesView $rolesView = new RolesView,
    )
    {
        parent::__construct();
    }

    public function actionIndex():void
    {
        $roles = $this->repo->all();
        $content = $this->rolesView->all($roles);
        $this->setVars(compact('content'));

    }

}
