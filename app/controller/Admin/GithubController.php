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
		$logger = new FileLogger();
		try {

			$logger->write('webhook1' . PHP_EOL);
			$content = file_get_contents('php://input');
			$objec = json_decode($content);
			$req = serialize($content) . PHP_EOL ?? '1' . PHP_EOL;
			$logger->write($req);
			$logger->write('type:' . gettype($objec) . PHP_EOL);
			$logger->write('completed - '.$objec['action'] . PHP_EOL);
			$logger->write(var_dump($_POST) . PHP_EOL);

			http_response_code(200);
			exit('type:' . gettype($objec) . PHP_EOL );


		} catch (\Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}

}
