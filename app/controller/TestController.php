<?php

namespace app\controller;

use app\core\Cache;
use app\model\User;
use app\model\Test;
use app\view\View;
use app\view\widgets\menu\Menu;
use app\core\App;
use app\model\Mail;


class TestController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->auth();
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
		View::setJs('test.js');
		View::setCss('test.css');
	}

	public function actionShow()
	{
		$this->layout = 'admin';
		$rootTests = App::$app->test->findWhere('isTest', 0);
		$this->set(compact('rootTests'));
		View::setCss('test_edit.css');
		View::setJs('test_edit.js');
	}

	public function actionUpdate()
	{
		$this->layout = 'admin';

		$id = $this->route['id'];
		$test = App::$app->test->findOne($id);

		$rootTests = App::$app->test->findWhere('isTest', 0);
		$this->set(compact('rootTests', 'test'));

		View::setCss('test_edit.css');
		View::setJs('test_edit.js');
	}

	public function actionCreate()
	{
		if ($this->ajax) {
			unset($this->ajax['token']);
			if (!$this->ajax['isTest']) {
				$this->ajax['parent'] = 0;
			}
			if ($id = App::$app->test->create($this->ajax)) {
				$q_id = App::$app->question->create();
//				$question_block = QuestionController::getQuestionBlock();
				exit(json_encode([
					'id' => $id,
//					'qestion_block' => $question_block,
				]));
			}
		}
	}

	public function actionEdit()
	{
		if ($this->ajax) {
			exit();
		}
		$this->layout = 'admin';

		$testId = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($testId) {
			$test = App::$app->test->findOne($testId);
			$testDataToEdit = App::$app->test->getTestData($testId);

			unset ($testDataToEdit['correct_answers']);
			$pagination = App::$app->test->pagination($testDataToEdit, true);
		} else {
			$testDataToEdit = [];
			$test['id'] = '';
			$test['test_name'] = '';
			$pagination = '';
			$error = '<H1>Теста с таким номером нет.</H1>';
		}
		$this->set(compact('test', 'testDataToEdit', 'pagination'));
		View::setJs('test_edit.js');
		View::setCss('test_edit.css');
	}

	public function actionResults()
	{
		$this->auth();

		if (array_key_exists('cache', $this->route)) {
			if ($this->route['cache']) {
				$file_name = $this->route['cache'];
				$cached_page = App::$app->cache->getFromCache($file_name);
				exit($cached_page);
			}
		}
	}

	public function actionDelete()
	{
		$this->auth();
		if (App::$app->test->delete($this->ajax['id'])) {
			exit(json_encode(['msg' => 'ok']));
		}
	}

	private function prepareCacheDir()
	{
		if (!is_dir(ROOT . '/tmp')) {
			mkdir(ROOT . '/tmp');
			if (!is_dir(ROOT . '/tmp/cache')) {
				mkdir(ROOT . '/tmp/cache');
				if (!is_dir(ROOT . '/tmp/cache/test_results')) {
					mkdir(ROOT . '/tmp/cache/test_results');
				}
			}
		} elseif (is_dir(ROOT . '/tmp')) {
			if (!is_dir(ROOT . '/tmp/cache')) {
				mkdir(ROOT . '/tmp/cache');
			} elseif (is_dir(ROOT . '/tmp/cache')) {
				if (!is_dir(ROOT . '/tmp/cache/test_results')) {
					mkdir(ROOT . '/tmp/cache/test_results');
				}
			}
		}
	}

	public function actionCachePageSendEmail()
	{
		if ($data = $this->ajax) {
			$this->prepareCacheDir();
			$file = md5(date(' d m - H i s'));
			$fileUTF8 = ROOT . '/tmp/cache/test_results/' . $file . '.txt';
//			$fileWin = mb_convert_encoding($fileUTF8, 'cp1251');

			if (file_put_contents($fileUTF8, $data['pageCache'])) {
				$data['to'] = [
					'vitaliy04111979@gmail.com',
//					'10@vitexopt.ru',
				];

				$data['subject'] = $this->getSubjectTestResults($data);
				$data['body'] = $this->prepareBodyTestResults($data, $file);
				$data['altBody'] = "Ссылка на страницу с результатами: тут";

				App::$app->mail->send_mail($data);
				exit(json_encode('ok'));
			}
		}
	}

	private function getSubjectTestResults($data)
	{
		return $errorSubj = $data['errorCnt'] == 0 ? 'СДАН' : "не сдан: {$data['errorCnt']} ош из {$data['questionCnt']}";
	}

	private function prepareBodyTestResults($data, $file)
	{
		$results_link = "http://" . $_SERVER['HTTP_HOST'] . '/test/results/' . $file;
		ob_start();
		require ROOT . '/app/view/Test/email.php';
		$template = ob_get_clean();
		return $template;
	}

	private function getMenu()
	{
		$menuTestDo = App::$app->cache->get('menuTestDo');
		if ($menuTestDo) return $menuTestDo;
		if (!$menuTestDo) {
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
	}

	public function actionGetCorrectAnswers()
	{
		App::$app->test->getCorrectAnswers();
	}

	public function actionDo()
	{
		$menuTestDo = $this->getMenu();
		$testId = (int)$this->route['alias'];
		$testData = App::$app->test->getTestData($testId, true);
		$test = App::$app->test->findOne($testId);
		$_SESSION['testData'] = $testData;
		if ($testData === 0) {//  0 - это просто альтернатива FALSE это папка
			$msg[] = 'Это папка! <a href = "/1">Перейти к тестам</a>';
			$error = include ROOT . '/app/view/User/alert.php'; //
			$this->set(compact('error', 'msg'));
		} elseif ($testData === FALSE) {//Теста с таким номером нет
			$error = '<H1>Теста с таким номером нет.</H1>';
			$this->set(compact('error'));
		}
//		$_SESSION['correct_answers'] = $testData['correct_answers'];
		unset($testData['correct_answers']);
		$pagination = App::$app->test->pagination($testData, false);
		$this->set(compact('testData', 'test', 'pagination', 'menuTestDo'));
		View::setJs('test.js');
		View::setCss('test.css');

	}
}
