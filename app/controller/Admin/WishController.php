<?php

namespace app\controller\Admin;

use app\action\admin\WishAction;
use app\service\Storage\StorageProd;
use JetBrains\PhpStorm\NoReturn;

class WishController extends AdminscController
{
    public function __construct(
        protected WishAction $actions,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $content = $this->actions->wishes();
        view('admin.wish.wish', ['content' => $content]);
    }

    public function actionSave(): void
    {
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            StorageProd::putFileContent('wish', $content);
            header('Location:/adminsc/wish');
        }
    }
}
