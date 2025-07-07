<?php

namespace app\controller\Admin;

use app\action\admin\RightAction;
use app\model\Right;
use JetBrains\PhpStorm\NoReturn;


class RightController extends AdminscController
{

    public function __construct(
        protected RightAction $actions,
        public string         $model = Right::class,
    )
    {
        parent::__construct();

    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }

}
