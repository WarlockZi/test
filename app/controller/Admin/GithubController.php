<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;
use app\Services\Logger\FileLogger;

class GithubController Extends AppController
{
	protected $model = Answer::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionWebhook()
	{
		$logger = new FileLogger();
		try {

			$content = file_get_contents('php://input');
			$objec = json_decode($content);
			if ($objec->action === 'completed') {
				$path = '/var/www/vitexopt/data/www/vitexopt.ru/';
				$res = shell_exec("cd {$path} && /usr/bin/git pull");
			}
			$logger->write('$path - ' . $path . PHP_EOL);

			http_response_code(200);
			exit('type:' . gettype($objec) . PHP_EOL);

		} catch (\Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}

}
