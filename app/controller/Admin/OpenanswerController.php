<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\core\Response;
use app\model\Openanswer;


class OpenanswerController Extends AdminscController
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
				$i = $this->ajax['sort'] ?? 1;

				$html = FS::getFileContent(ROOT . '/app/view/Opentest/edit_BlockAnswer.php');
				Response::json(['html' => $html]);
			}
			Response::exitWithPopup('ok');
		}
	}


	public function actionDelete():void
	{
		$id = $this->ajax['id'];
		if (Openanswer::delete($id)) {
			Response::exitWithPopup('ok');
		}
	}

}
