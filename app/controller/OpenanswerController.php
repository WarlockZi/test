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
		try {
			if ($this->ajax) {
				$res = $this->model::updateOrCreate($this->ajax);
				if (is_int($res)) {
					$a['id'] = $res;
					$a['answer'] = '';
					$i = $this->ajax['sort']??1;

					ob_start();
					include ROOT . '/app/view/Opentest/edit_BlockAnswer.php';
					$html = ob_get_clean();
					exit(json_encode(['id' => $res, 'html' => $html]));
				}
				$this->exitWith('ok');
			}
		} catch (Exception $exception) {
			exit($exception->getMessage());
		};
	}


	public function actionDelete()
	{
		$id = $this->ajax['id'];
		if (Openanswer::delete($id)) {
			$this->exitWith('ok');
		}
	}

}
