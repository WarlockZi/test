<?php

namespace app\controller\Admin;

use app\action\admin\CountryAction;
use app\model\Country;
use JetBrains\PhpStorm\NoReturn;

class CountryController extends AdminscController
{
    public string $model = Country::class;

    public function __construct(
        protected CountryAction $actions,
    )
    {
        $this->actions = new CountryAction();
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable(new CountryAction());
    }
}
