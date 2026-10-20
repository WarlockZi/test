<?php

namespace app\controller\Admin;

use app\action\admin\VideoAction;
use app\model\Videoinstruction;
use app\view\Videoinstruction\VideoinstructionView;

class VideoinstructionController extends AdminscController
{


    public function __construct(
        protected VideoAction $actions,
        protected string      $model = Videoinstruction::class,
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {

        $this->showTable();
    }

    public function actionEdit(): void
    {
        $VideoinstructionsView = VideoinstructionView::listAll();

    }
}
