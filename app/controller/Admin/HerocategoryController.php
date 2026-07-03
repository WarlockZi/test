<?php

namespace app\controller\Admin;


use app\blade\views\admin\heroCategories\HerocategoryFormView;
use app\model\Herocategory;
use JetBrains\PhpStorm\NoReturn;

class HerocategoryController extends AdminscController
{
    public string $model = Herocategory::class;

    public function __construct()
    {
        parent::__construct();
    }

    #[NoReturn]
    public function actionIndex(): void
    {
        $heroCategories = HerocategoryFormView::admin();
        view('admin.heroCategories.heroCategories', compact('heroCategories'));
    }
}
