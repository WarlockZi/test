<?php

namespace app\controller;

use app\model\User;
use app\model\Test;
use app\core\Base\View;
use app\view\widgets\menu\Menu;
use app\core\App;

class TestController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->auth();
		View::setCss(['css' => '/public/build/test.css']);
		View::setJs(['js' => '/public/build/test.js']);

	}

	public function actionIndex()
	{

		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
		View::setJs(['js' => '/public/build/test.js']);
		View::setCss(['css' => '/public/build/test.css']);
	}

	public function actionEdit()
	{

		// Загрузка картинок drag-n-drop
		if (isset($_FILES['file']) && !empty($_FILES['file'])) {
			App::$app->test->QPic();
			exit();
		} elseif ($this->isAjax()) {
			$func = $_POST['action'];
			App::$app->test->$func();
			exit();
		}

		$testId = (int)$this->route['alias'];

		$testDataToEdit = App::$app->test->getTestData($testId);
		unset ($testDataToEdit['correct_answers']);
		if ($testDataToEdit === FALSE) {//Вообще не нашли такого теста с номером
			$error = '<H1>Теста с таким номером нет.</H1>';
			$this->set(compact('css', 'error'));
		}

		$pagination = App::$app->test->paginationEdit($testDataToEdit);
		$this->set(compact('testDataToEdit', 'pagination', 'testId'));

	}

	public function actionResults()
	{

		$this->getFromCache('/results/test/');
		exit();
		View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');


		if (array_key_exists('cache', $this->route)) {
			if ($this->route['cache']) {
				$cache = $this->route['cache'];
			}
		}

		$file = ROOT . '/tmp/cache/results/' . $cache . '.txt';
		if (file_exists($file)) {
			$results = require $file;
		}

		$this->set(compact('results'));
		exit();
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


	public function actionDo()
	{

		$menuTestDo = $this->getMenu();

		$testId = (int)$this->route['alias'];
		$testData = App::$app->test->getTestData($testId);

		$_SESSION['testData'] = $testData;


		if ($testData === 0) {//  0 - это просто альтернатива FALSE это папка
			$msg[] = 'Это папка! <a href = ' . PROJ . '/1>Перейти к тестам</a>';
			$error = include ROOT . '/app/view/User/alert.php'; //
			$this->set(compact('error', 'msg'));
		} elseif ($testData === FALSE) {//Теста с таким номером нет
			$error = '<H1>Теста с таким номером нет.</H1>';
			$this->set(compact('error'));
		}

		$_SESSION['correct_answers'] = $testData['correct_answers'];
		unset($testData['correct_answers']);
		$pagination = App::$app->test->pagination($testData);
		$this->set(compact('testData', 'pagination', 'menuTestDo'));

	}

}
