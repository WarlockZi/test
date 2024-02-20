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
//				$path = '/var/www/vitexopt/data/www/vitexopt.ru/';

				$time = date('H:i:s');

				$cd = `cd /var/www/vitexopt/data/www/vitexopt.ru/`;

				$logger->write('$cd time -' . $time . $cd . PHP_EOL);

				$pull = `/usr/bin/git pull`;
//				$pullOutput = shell_exec($pull);
				$logger->write('$pull - ' . $pull . PHP_EOL);

				$build = `npm run build`;
				$logger->write('$build - ' . $build . PHP_EOL);


				$who = `whoami`;
				$logger->write('whoam I- ' . $who . PHP_EOL);
			}


			http_response_code(200);
			exit('type:' . gettype($objec) . PHP_EOL);

		} catch (Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}


}
