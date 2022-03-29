<?php

namespace app\controller;

use app\model\Mail;
use app\model\Model;
use app\model\Question;
use app\model\Test;
use app\model\TestResult;
use app\view\components\CustomListTree\CustomListTree;
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
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
//		View::setJs('admin.js');
//		View::setCss('admin.css');
	}

	public function actionShow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';

		$page_name = 'Создание теста';
		$this->set(compact('page_name'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$test['isTest'] = 1;
		$this->set(compact('test'));
	}

	public function actionPathshow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$page_name = 'Создание папки';
		$this->set(compact('page_name'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$test['isTest'] = 0;
		$rootTests = Test::findAllWhere('isTest', 0);
		$this->set(compact('rootTests', 'test'));
	}


	public function actionCreate()
	{
		if ($this->ajax) {

			if ($id = Test::create($this->ajax)) {
				$q_id = Question::create();
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
				$q_id = Question::create();
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}


	public function actionResult()
	{
		$cache = $this->route['cache'];
		$res = TestResult::findOneWhere('cache', $cache);
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
		if (User::can($this->user, 4) || defined(SU)) {
			if (Test::delete($this->ajax['test']['id'])) {
				$this->exitWith('ok');
			}
		}
		Test::update($this->ajax['test']);
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
			return TestResult::delete($id);

		}
	}

	private static function saveResultToDB()
	{
		$testres['html'] = $_POST['pageCache'];
		$testres['user'] = $_POST['userName'];
		$testres['errorCnt'] = $_POST['errorCnt'];
		$testres['questionCnt'] = $_POST['questionCnt'];
		$testres['testid'] = $_POST['testId'];
		$testres['testname'] = $_POST['test_name'];
		return TestResult::create($testres);
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

		Mail::send_mail($data);;
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
		return $errorSubj = "{$data['user']}:{$data['errorCnt']} ош из {$data['questionCnt']}";
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
		$su = defined('SU');
		if (User::can($this->user, 'test-do_read') || $su) {

			$pagination = '';
			$testData = '';
			$page_name = 'Прохождение тестов';

			$this->set(compact('page_name'));
			$testId = isset($this->route['alias']) ? (int)$this->route['alias'] : '';

//			$menuTestDo = $this->getMenu();
//			$this->set(compact('menuTestDo'));

			if ($testId) {
				if (!$testData = App::$app->test->getTestData($testId, true)) {
					$error = '<H1>Теста с таким номером нет.</H1>';
					$this->set(compact('error'));
				} else {
					$test = Test::findOneWhere('id', $testId);
					$this->set(compact('test'));
					$_SESSION['correct_answers'] = $testData['correct_answers'] ?? null;
					unset($testData['correct_answers']);
					$pagination = App::$app->test->pagination($testData, false, $test);
				}
			}

			$this->set(compact('testData', 'pagination'));

		} else {

			header('Location:/');

		}
	}

	private function pathsTree(Model $model)
	{
		$model->data = $model->findAll();
		return $model->tree('parent');
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			$id = Test::update($this->ajax);
			exit(json_encode(['id' => $id]));
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';
		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = $this->route['id'];
		$test = Test::findOneWhere('id', $id);
		$test['children'] = Test::findAllWhere('parent', $id);;
		$this->set(compact('test'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$pathsTree = $this->pathsTree(new Test);
		$select = CustomListTree::run([
			'separator' => '',
			'initialOption' => false,
			'tree' => $pathsTree,
		]);
		$this->set(compact('paths'));

//		View::setCss('admin.css');
//		View::setJs('admin.js');
	}


	public function actionPaths()
	{
		exit(json_encode($this->paths()));
	}

	private function paths()
	{
		return Test::findAllWhere('isTest', '0');
	}

	public function actionTests()
	{
		exit(json_encode($this->isTest()));
	}

	private function isTest()
	{
		return Test::findAllWhere('isTest', '1');
	}

	public function actionEdit()
	{
		$test = '';
		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($id) {
			$test = Test::findOneWhere('id', $id);
			if ($test) {
				if (!$test['isTest']) {
					$test['children'] = Test::findAllWhere('parent', $id);;
				}
			}
			$tests = $this->isTest();
			$this->set(compact('tests'));

			$testDataToEdit = App::$app->test->getTestData($id) ?? '';
			unset ($testDataToEdit['correct_answers']);
			$this->set(compact('testDataToEdit'));

		}
		$this->set(compact('test'));

	}
}
