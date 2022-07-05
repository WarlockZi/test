<?php

namespace app\controller;

use app\model\Right;
use app\model\Videoinstruction;
use app\view\Videoinstruction\VideoinstructionView;
use app\view\View;

class VideoinstructionController Extends AppController
{
	protected $model = Videoinstruction::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionIndex()
	{
		$videos = Videoinstruction::where('id','>',0)
			->orderBy(['tag','sort'])
			->get();
		$this->set(compact('videos'));
	}

	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)) {
				$this->exitJson([
					'id' => $id-1,
				]);
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::updateOrCreate($this->ajax)) {
				if (is_bool($id)) {
					$this->exitWithPopup('Сохранено');
				}else{
					$this->exitJson(['id'=>$id,'msg'=>'Создан']);
				}
			}
		}
	}


	public function actionDelete()
	{
	}

	public function actionEdit()
	{
		$VideoinstructionsView = VideoinstructionView::list();
		$this->set(compact('VideoinstructionsView'));
	}


}
