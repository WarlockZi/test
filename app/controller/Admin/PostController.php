<?php

namespace app\controller\Admin;

use app\action\admin\PostAction;
use app\model\Post;
use app\service\Response;
use app\view\Post\PostView;
use JetBrains\PhpStorm\NoReturn;

class PostController extends AdminscController
{

    public function __construct(
        protected PostAction $actions,
        public string        $model = Post::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
    }


    public function actionEdit()
    {
        if ($this->ajax) {
            $this->model::update($this->ajax);
            Response::exitWithPopup('ok');
        }
        $id = $this->route['id'];

        $item = PostView::item($id);
        $this->setVars(compact('item'));
    }

    private function getItem($item, $chiefs, $subordinates)
    {
        return include ROOT . '/app/view/Post/getItem.php';
    }

    protected function getMultiselectCheifs($array, $selected)
    {
        return include ROOT . '/app/view/Post/getMultiselectCheifs.php';
    }

    protected function getMultiselectSubordinates($array, $selected)
    {
        return include ROOT . '/app/view/Post/getMultiselectSubordinates.php';
    }


    public function actionDelete(): void
    {
        $id = $this->ajax['id'] ?? $_POST['id'];

        if ($this->model::delete($id)) {
            Response::exitWithPopup("ok");
        }

        header('Location:/adminsc/post/table');
    }


}
