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

		$logger->write('webhook4');
		$req = $_POST ?? '1' . PHP_EOL;
		$logger->write($req);

		$logger->write('webhook1');
		$req = json_decode(file_get_contents('php://input'), true) ?? '1' . PHP_EOL;
		$logger->write($req);

		$logger->write('webhook2');
		$req = json_encode(file_get_contents('php://input')) ?? '2' . PHP_EOL;
		$logger->write($req);

		$logger->write('webhook3');
		$req = json_decode(file_get_contents($_POST), true) ?? '1' . PHP_EOL;
		$logger->write($req);


		http_response_code(200);
//		header();json_encode($_GET)

		exit('jj');
	}
}
