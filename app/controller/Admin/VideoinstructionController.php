<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\core\Route;
use app\model\Videoinstruction;
use app\view\Videoinstruction\VideoinstructionView;

class VideoinstructionController Extends AppController
{

	protected string $model = Videoinstruction::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$videos = Videoinstruction::where('id', '>', 0)
//			->orderBy(['tag', 'sort'])
			->orderBy('tag')
			->orderBy('sort')
			->get();
		$this->setVars(compact('videos'));
	}

	public function actionEdit()
	{
		$VideoinstructionsView = VideoinstructionView::listAll();
		$this->setVars(compact('VideoinstructionsView'));
	}
}
