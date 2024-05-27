<?php

namespace app\controller;


use app\core\FS;
use app\view\Assets\BotAssets;

class BotController extends AppController
{
	protected $css;
	protected $js;
	protected $assets;

	public function __construct()
	{
		parent::__construct();
		$this->assets = new BotAssets();
	}

	public function actionIndex():void
	{
		$assets = $this->assets;
		$content = FS::getFileContent(ROOT.'/app/view/Bot/index.php',compact('assets'));

		exit($content);
	}

	public function actionLeadgen()
	{
		$assets = $this->assets;
		$content = FS::getFileContent(ROOT.'/app/view/Bot/index.php',compact('assets'));

		exit($content);
	}


}
