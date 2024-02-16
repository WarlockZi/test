<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;
use app\Services\Logger\FileLogger;
use Exception;

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

				$cd = "cd {$path}";
				$lsOutput = shell_exec($cd);


				$ls = "ls -la";
				shell_exec($ls);
				$logger->write('$lsOutput - ' . $lsOutput . PHP_EOL);

				$pull = "/usr/bin/git pull";
				$pullOutput = shell_exec($pull);
				$logger->write('$pullOutput - ' . $pullOutput . PHP_EOL);
			}

			http_response_code(200);
			exit('type:' . gettype($objec) . PHP_EOL);


		} catch (Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}

}
