<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Services\Logger\FileLogger;

class GithubController Extends AppController
{
	protected $model = Github::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionWebhook()
	{
		$req = json_decode(file_get_contents('php://input'), true);
		$logger = new FileLogger();
		$logger->write($req);
	}


}
