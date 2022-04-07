<?php

namespace app\controller;

use app\core\App;
use app\model\Mail;
use app\model\Model;
use app\model\Question;
use app\model\Test;
use app\model\TestResult;
use app\model\User;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomSelect\CustomSelect;
use app\view\View;
use app\view\widgets\menu\Menu;


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
	}


	public function actionUpdate()
	{
		if ($this->ajax) {
			$id = Test::update($this->ajax);
			exit(json_encode(['id' => $id]));
		}

		$this->view = 'edit_update';

		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = $this->route['id'];
		$test = Test::findOneWhere('id', $id);
		$test['children'] = Test::findAllWhere('parent', $id);;
		$this->set(compact('test'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$tree = [0 => 'да', 1 => 'нет'];
		$enableSelect = $this->getEnableCustomSelect($tree);
		$this->set(compact('enableSelect'));

		$pathsTree = $this->pathsTree(new Test);
		$parentSelect = $this->getParentCustomSelect($pathsTree);
		$this->set(compact('parentSelect'));
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
		$id = $this->route['id'];
		$res = TestResult::findOneWhere('id', $id);
		exit($res['html']);
	}

	public function actionResults()
	{
		$res = TestResult::findAll('testResults');
		$this->set(compact('res'));
	}

	public function actionDelete()
	{

		if (User::can($this->user, 4) || defined(SU)) {
			if (Test::delete($this->ajax['test']['id'])) {
				$this->exitWith('ok');
			}
		}
		$this->ajax['test']['enable'] = 0;
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
		$model->data = $model->findAllWhere('isTest', '0');
		return $model->tree('parent');
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


	private function getEnableCustomSelect($tree)
	{
		return CustomSelect::run([
			'selectClassName' => 'custom-select',
			'title' => 'Показывать пользователям',
			'field' => 'parent',
			'tab' => '&nbsp;&nbsp;&nbsp;',
			'initialOption' => true,
			'initialOptionValue' => '---',
			'nameFieldName' => 'test_name',
			'tree' => [0 => 'да', 1 => 'нет'],
		]);
	}

	private function getParentCustomSelect($tree)
	{
		return CustomSelect::run([
			'selectClassName' => 'custom-select',
			'title' => 'Лежит в папке',
			'field' => 'parent',
			'tab' => '&nbsp;&nbsp;&nbsp;',
			'initialOption' => true,
			'initialOptionValue' => '---',
			'nameFieldName' => 'test_name',
			'tree' => $tree,
		]);
	}


	private function getItem($item, $chiefs, $subordinates,$subordinates1)
	{
		return new CustomCatalogItem(
			[
				'item' => $item,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'fields' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'contenteditable' => '',
						'width' => '50px',
						'data-type' => 'number',
					],
					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
					'full_name' => [
						'className' => 'fullname',
						'field' => 'full_name',
						'name' => 'Полное наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
					'cheif' => [
						'className' => 'cheif',
						'field' => 'cheif',
						'name' => 'Подчиняется',
						'width' => '1fr',
						'contenteditable' => false,
						'data-type' => 'select',
						'select' => $chiefs,
					],
					'subourdinate' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'select',
						'select' => $subordinates,
					],
					'subourdinate1' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'multiselect',
						'select' => $subordinates1,
					],
				],

				'delBttn' => 'ajax',
				'toListBttn' => true,
				'saveBttn' => 'ajax',//'redirect'
			]
		);
	}

}
