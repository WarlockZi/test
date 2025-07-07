<?php

namespace app\controller\Admin;

use app\model\Country;
use JetBrains\PhpStorm\NoReturn;

class CountryController extends AdminscController
{
    public string $model = Country::class;

    public function __construct()
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }
}
