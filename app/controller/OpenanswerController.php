<?php

namespace app\controller;

use app\model\Openanswer;


class OpenanswerController Extends AppController
{
	private $model = Openanswer::class;
	private $table = 'openanswers';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$a['id'] = $this->model::updateOrCreate($this->ajax);
			if (is_int($a['id'])) {
				$a['answer'] = '';
				$i = $this->ajax['sort'] ?? 1;

				ob_start();
				include ROOT . '/app/view/Opentest/edit_BlockAnswer.php';
				$html = ob_get_clean();
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
