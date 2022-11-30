<?php

namespace app\controller;

use app\core\Auth;
use app\model\Illuminate\Videoinstruction;
use app\view\Videoinstruction\VideoinstructionView;

class VideoinstructionController Extends AppController
{
	public $model = Videoinstruction::class;

	public function __construct(array $route)
	{
		parent::__construct($route);

	}

	public function actionIndex()
	{
		$videos = Videoinstruction::where('id', '>', 0)
//			->orderBy(['tag', 'sort'])
			->orderBy('tag')
			->orderBy('sort')
			->get();
		$this->set(compact('videos'));
	}

//	public function actionCreate()
//	{
//		if ($this->ajax) {
//			if ($id = $this->model::create($this->ajax)) {
//				$this->exitJson([
//					'id' => $id-1,
//				]);
//			}
//		}
//	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::updateOrCreate($this->ajax)) {
				if (is_bool($id)) {
					$this->exitWithPopup('Сохранено');
				} else {
					$this->exitJson(['id' => $id, 'msg' => 'Создан']);
				}
			}
		}
	}


	public function actionDelete()
	{
		$id = $this->ajax['id'] ?? $_POST['id'];
		if ($this->model::delete($id)) {
			$this->exitWithPopup("ok");
		}
	}

	public function actionEdit()
	{
		Auth::checkAuthorized($this->user, ['role_admin']);
		$VideoinstructionsView = VideoinstructionView::listAll();
		$this->set(compact('VideoinstructionsView'));
	}
}
