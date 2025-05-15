<?php


namespace app\controller\Admin;


use app\action\admin\TagAction;
use app\model\Tag;

class TagController extends AdminscController
{

    public string $model = Tag::class;
    public function __construct(
        protected TagAction $actions,
    )
    {
        parent::__construct();

    }

    public function actionIndex(): void
    {
        $this->showTable();
    }

}