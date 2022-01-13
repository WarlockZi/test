<?php

namespace app\controller;

use app\view\View;
use app\view\widgets\menu\Menu;
use app\core\App;
use app\model\User;

use app\view\widgets\Tree\Tree;


class TestController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
		View::setJs('test.js');
		View::setCss('test.css');
	}

//	public function actionTree()
//	{
//		if ($data = $this->ajax) {
//			$table = $data['table'];
//			$menu = new tree(['table' => $table]);
//		}
//	}


	public function actionShow()
	{
		$this->layout = 'admin';
		$rootTests = App::$app->test->findAllWhere('isTest', 0);
		$test['isTest'] = 1;
		$this->set(compact('rootTests', 'test'));
		View::setCss('test_edit.css');
		View::setJs('test_edit.js');
	}

	public function actionPathshow()
	{
		$this->layout = 'admin';
		$this->view = 'show';
		$test['isTest'] = 0;
		$rootTests = App::$app->test->findAllWhere('isTest', 0);
//		$rootTestsTree = $this->hierachy($rootTests, 'parent');
		$this->set(compact('rootTests', 'test'));
		View::setCss('test_edit.css');
		View::setJs('test_edit.js');
	}


	public function actionCreate()
	{
		if ($this->ajax) {

			if ($id = App::$app->test->create($this->ajax)) {
				$q_id = App::$app->question->create();
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {

			if ($id = App::$app->test->updateOrCreate($this->ajax['id'], $this->ajax)) {
				$q_id = App::$app->question->create();
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}


	public function actionResult()
	{
		$cache = $this->route['cache'];
		$res = App::$app->testresult->findOne($cache);
		$this->set(compact('res'));

		exit($res['html']);
	}

	public function actionResults()
	{
		if (array_key_exists('cache', $this->route)) {
			if ($this->route['cache']) {
				$file_name = $this->route['cache'];
				$dir = ROOT . '\tmp\cache\test_results\\';
				$cached_page = App::$app->cache->getFromCache($dir, $file_name);
				exit($cached_page);
			}
		}
	}

	public function actionDelete()
	{
		if (User::can($this->user, 4) || SU) {
			if (App::$app->test->delete($this->ajax['test']['id'])) {
				exit(json_encode(['msg' => 'ok']));
			}
		}
		App::$app->test->update($this->ajax['test']);
		exit(json_encode(['notAdmin' => true]));
	}


	private static function getMailsToSendBothResults()
	{
		return explode(',', $_ENV['TEST_EMAIL_ALL']);
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

	public function actionResultdelete($post)
	{
		if ($id = $this->ajax['id']) {
			return App::$app->testresult->delete($id);

		}
	}

	private static function saveResultToDB($post)
	{
		$testres['html'] = $_POST['pageCache'];
		$testres['user'] = $_POST['userName'];
		$testres['errorCnt'] = $_POST['errorCnt'];
		$testres['questionCnt'] = $_POST['questionCnt'];
		$testres['testid'] = $_POST['testId'];
		$testres['testname'] = $_POST['test_name'];
		return App::$app->testresult->create($testres);
	}

	private static function sendTestRes($post, $resid)
	{
		if (!$_ENV['TEST_EMAIL_ALL_SEND']) {
			exit(json_encode('mail not sent'));
		}
		$data['to'] = self::getMailsToSendBothResults();

		$data['to'] = self::getMailsToSendIfRightResults($data['to'], $post['errorCnt']);

		$data['subject'] = self::getSubjectTestResults($post);
		$data['body'] = self::prepareBodyTestResults($post, $resid - 1);
		$data['altBody'] = "Ссылка на страницу с результатами: тут";

		App::$app->mail->send_mail($data);
		exit(json_encode('ok'));
	}

	public function actionCachePageSendEmail()
	{
		$mail = 1;

		if (isset($_POST) && is_array($_POST)) {

			if ($resid = self::saveResultToDB($_POST)) {
				if (!$resid) exit('Результат в базу не сохранен');

				if (!$mail) exit(json_encode('ok'));
				self::sendTestRes($_POST, $resid);
			}
		}
	}

	private static function getSubjectTestResults($data)
	{
		return $errorSubj = $data['errorCnt'] == 0 ? 'СДАН' : "не сдан: {$data['errorCnt']} ош из {$data['questionCnt']}";
	}

	private static function prepareBodyTestResults($data, $id)
	{
		$results_link = "http://" . $_SERVER['HTTP_HOST'] . '/test/result/' . $id;
		ob_start();
		require ROOT . '/app/view/Test/do_email.php';
		$template = ob_get_clean();
		return $template;
	}

	private function getMenu()
	{
		ob_start();
		new Menu([
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/do_test_menu.php",
			'cache' => 60,
			'sql' => "SELECT * FROM test WHERE enable = '1'"
		]);
		$menuTestDo = ob_get_clean();

		App::$app->cache->set('menuTestDo', $menuTestDo, 60 * 5);
		return $menuTestDo;
	}

	public function actionGetCorrectAnswers()
	{
		App::$app->test->getCorrectAnswers();
	}

	public function actionDo()
	{
		$pagination = '';
		$testData = '';
		$testId = isset($this->route['alias']) ? (int)$this->route['alias'] : '';
		$menuTestDo = $this->getMenu();
		$this->set(compact('menuTestDo'));

		if ($testId) {
			if (!$testData = App::$app->test->getTestData($testId, true)) {
				$error = '<H1>Теста с таким номером нет.</H1>';
				$this->set(compact('error'));
			}else{
				$test = App::$app->test->findOne($testId);
				$this->set(compact('test'));
				$_SESSION['correct_answers'] = $testData['correct_answers'] ?? null;
				unset($testData['correct_answers']);
				$pagination = App::$app->test->pagination($testData, false, $test);
			}
		}

		$this->set(compact('testData', 'pagination'));

		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			$id = App::$app->test->update($this->ajax);
			exit(json_encode(['id' => $id]));
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

		$id = $this->route['id'];
		$test = App::$app->test->findOne($id);
		$test['children'] = App::$app->test->getChildren($id);

		$rootTests = App::$app->test->findAllWhere('isTest', 0);
//		$rootTestsTree = $this->hierachy($rootTests, 'parent');
		$this->set(compact('rootTests', 'test'));

		View::setCss('admin.css');
		View::setJs('admin.js');
	}

	public function actionEdit()
	{
		$test = '';
		$id = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($id) {
			$test = App::$app->test->findOne($id);
			if ($test) {
				if (!$test['isTest']) {
					$test['children'] = App::$app->test->getChildren($id);
				}
			}
			$testDataToEdit = App::$app->test->getTestData($id) ?? '';
			unset ($testDataToEdit['correct_answers']);
			$this->set(compact('testDataToEdit'));
		}
		$this->set(compact('test'));

		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}
}
