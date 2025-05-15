<?php

namespace app\controller\Admin;

use app\action\admin\ManufacturerAction;
use app\model\manufacturer;
use JetBrains\PhpStorm\NoReturn;

class ManufacturerController extends AdminscController
{

    public function __construct(
        protected ManufacturerAction $actions,
        public string                $model = manufacturer::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }
}
