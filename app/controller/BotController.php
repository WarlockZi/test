<?php

namespace app\controller;


use app\core\FS;

class BotController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$content = FS::getFileContent(ROOT.'/app/view/Bot/index.php');

		exit($content);
	}

}
