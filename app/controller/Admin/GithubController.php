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

			$logger->write('webhook1'. PHP_EOL );
			$req = serialize(file_get_contents('php://input') ). PHP_EOL ?? '1' . PHP_EOL;
			$logger->write($req);

			$logger->write('webhook2'. PHP_EOL );
			$req = json_encode(file_get_contents('php://input')). PHP_EOL ?? '2' . PHP_EOL;
			$logger->write($req);

			http_response_code(200);
			exit(var_dump($_POST));

		} catch (\Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}
}
