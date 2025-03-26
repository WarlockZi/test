<?php

namespace app\controller\Admin;

use app\model\Videoinstruction;
use app\view\Videoinstruction\VideoinstructionView;

class VideoinstructionController extends AdminscController
{

    protected string $model = Videoinstruction::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $videos = Videoinstruction::where('id', '>', 0)
//			->orderBy(['tag', 'sort'])
            ->orderBy('tag')
            ->orderBy('sort')
            ->get();
        $this->setVars(compact('videos'));
    }

    public function actionEdit()
    {
        $VideoinstructionsView = VideoinstructionView::listAll();
        $this->setVars(compact('VideoinstructionsView'));
    }
}
