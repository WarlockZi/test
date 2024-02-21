<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;
use app\Services\Logger\FileLogger;
use Carbon\Traits\Date;
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

		http_response_code(200);
		exit('type:' . PHP_EOL);

		$logger = new FileLogger();
		$time = date('m/d/Y h:i:s a', time());
		$logger->write("time {$time} " . PHP_EOL);
		try {
//			$content = file_get_contents('php://input');
//			$objec = json_decode($content);


			$e = exec('/bin/bash ../../../../.scripts/deploy.sh');
			$logger->write("time {$time} exe {$e}" . PHP_EOL);


			http_response_code(200);
			exit('type:' . PHP_EOL);

		} catch (Exception $e) {
			$logger->write('error' . $e->getMessage());
		}
	}


}
