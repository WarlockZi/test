<?php


namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\core\Route;
use app\model\TestResult;
use app\core\PHPMail;


class TestresultController extends AppController
{
	public $model = TestResult::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$res = TestResult::all()->toArray();
		$this->set(compact('res'));
	}

	public function actionResult()
	{
		$res = TestResult::find($this->route->id);
		$testHtml= $res->html;
		$this->set(compact('testHtml', 'res'));
	}


	private static function getMailsToSendIfRightResults($mailsTo, $errCount)
	{
		$sendIfLessOrEqualThen = 0;
		$mails = explode(',', $_ENV['TEST_EMAIL_ONLY_CORRECT']);

		if ((int)$errCount <= $sendIfLessOrEqualThen) {
			return array_merge($mailsTo, $mails);
		}
		return $mailsTo;
	}

	public function actionCreate()
	{
		if ($this->ajax) {
			$result = TestResult::create($this->ajax);
			if ($result->wasRecentlyCreated ) {
				$this->sendTestResult($this->ajax, $result->id-1);
				$this->exitWithPopup('Результат сохранен');
			}else{
				$this->exitWithPopup('Результат в базу не сохранен');
			}
		}
	}

	private function sendTestResult($post, $resid)
	{
		if ($_ENV['TEST_EMAIL_ALL_SEND']) {
			exit(json_encode('mail not sent'));
		}
		$data['to'] = explode(',', $_ENV['TEST_EMAIL_ALL']);

		$data['to'] = self::getMailsToSendIfRightResults($data['to'], $post['errorCnt']);

		$data['subject'] = "{$post['user']}:{$post['errorCnt']} ош из {$post['questionCnt']}";
		$data['body'] = self::prepareBodyTestResults($post, $resid - 1);
		$data['altBody'] = "Ссылка на страницу с результатами: тут";

		$sent = PHPMail::send_mail($data);
		$this->exitWithPopup('Результат сохранен');
	}

	private static function prepareBodyTestResults($data, $id)
	{
		$results_link = "http://" . $_SERVER['HTTP_HOST'] . '/adminsc/testresult/result/' . $id;
		$template = FS::getFileContent(ROOT . '/app/view/TestResult/do_email.php',compact('data'));
		return $template;
	}

}