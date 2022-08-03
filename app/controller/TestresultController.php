<?php


namespace app\controller;

use app\model\Mail;
use app\model\TestResult;


class TestresultController extends AppController
{
	public $model = TestResult::class;

	public function __construct(array $route)
	{
		parent::__construct($route);

	}
	public function actionIndex()
	{
		$res = TestResult::findAll('testResults');
		$this->set(compact('res'));
	}

	public function actionResult()
	{
		$id = $this->route['id'];
		$res = TestResult::findOneWhere('id', $id);
		$testHtml= $res['html'] ;
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
			if ($resid = TestResult::create($this->ajax)) {
				$this->sendTestRes($this->ajax, $resid-1);
				$this->exitWithPopup('Результат сохранен');
			}else{
				$this->exitWithPopup('Результат в базу не сохранен');
			}
		}
	}

	private function sendTestRes($post, $resid)
	{
		if ($_ENV['TEST_EMAIL_ALL_SEND']) {
			exit(json_encode('mail not sent'));
		}
		$data['to'] = explode(',', $_ENV['TEST_EMAIL_ALL']);

		$data['to'] = self::getMailsToSendIfRightResults($data['to'], $post['errorCnt']);

		$data['subject'] = "{$post['user']}:{$post['errorCnt']} ош из {$post['questionCnt']}";
		$data['body'] = self::prepareBodyTestResults($post, $resid - 1);
		$data['altBody'] = "Ссылка на страницу с результатами: тут";

		$sent = Mail::send_mail($data);
		$this->exitWithPopup('Результат сохранен');
	}

	private static function prepareBodyTestResults($data, $id)
	{
		$results_link = "http://" . $_SERVER['HTTP_HOST'] . '/adminsc/testresult/result/' . $id;
		ob_start();
		require ROOT . '/app/view/TestResult/do_email.php';
		$template = ob_get_clean();
		return $template;
	}

}