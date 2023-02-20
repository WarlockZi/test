<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\model\Videoinstruction;
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

	public function actionEdit()
	{
		Auth::checkAuthorized(Auth::getUser(), ['role_admin']);
		$VideoinstructionsView = VideoinstructionView::listAll();
		$this->set(compact('VideoinstructionsView'));
	}
}
