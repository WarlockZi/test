<?php

namespace app\controller\Admin;

use app\model\Openanswer;
use app\service\FS;
use app\service\Response;


class OpenanswerController extends AdminscController
{
    private $model = Openanswer::class;
    private $table = 'openanswers';

    public function __construct(array $route)
    {
        parent::__construct();

    }

    public function actionUpdateOrCreate()
    {
        if ($this->ajax) {
            $a['id'] = $this->model::updateOrCreate($this->ajax);
            if (is_int($a['id'])) {
                $a['answer'] = '';
                $i           = $this->ajax['sort'] ?? 1;

                $html = FS::getFileContent(ROOT . '/app/view/Opentest/edit_BlockAnswer.php');
                response()->json(['html' => $html]);
            }
            Response::exitWithPopup('ok');
        }
    }


    public function actionDelete(): void
    {
        $id = $this->ajax['id'];
        if (Openanswer::delete($id)) {
            Response::exitWithPopup('ok');
        }
    }

}
