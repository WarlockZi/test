<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\model\Openanswer;


class OpenanswerController Extends AppController
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
				$this->exitJson(['html' => $html]);
			}
			$this->exitWithPopup('ok');
		}
	}


	public function actionDelete()
	{
		$id = $this->ajax['id'];
		if (Openanswer::delete($id)) {
			$this->exitWithPopup('ok');
		}
	}

}
