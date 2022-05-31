<?php

namespace app\controller;

use app\view\View;
use app\model\Freetest;
use app\controller\AppController;
use app\core\App;
use app\view\widgets\menu\Menu;
use app\view\widgets\pagination\Pagination;

class FreetestController extends AppController
{

	public function actionEdit()
	{
		$this->autorize();

		$Freetest = new Freetest;
		// Загрузка картинок drag-n-drop
		if (isset($_FILES['file']) && !empty($_FILES['file'])) {
			$Freetest->QPic();
			exit();
		} elseif ($this->isAjax()) {
			$func = $_POST['action'];
			$Freetest->$func();
			exit();
		}

		//Получим id теста
		if (is_array($this->route)) {
			if (array_key_exists('alias', $this->route)) {
				if ($this->route['alias']) {
					$testId = (int)$this->route['alias'];
				}
			} else {
				$testId = 1;
			}
		}

		$freeTestDataToEdit = $Freetest->getFreeTestDataToEdit($testId);
		View::setCss('freeTest.css');
		View::setJs('freeTest.js');

		if ($freeTestDataToEdit === FALSE) {//Вообще не нашли такого теста с номером
			$error = '<H1>Теста с таким номером нет.</H1>';
			$this->set(compact('error'));
		}

		if ($freeTestDataToEdit) {
			$pagination = $Freetest->paginationEdit($freeTestDataToEdit, $testId);
			$this->set(compact('freeTestDataToEdit', 'pagination', 'testId'));
		}
		View::setMeta('Редактор тестов', 'Редактор тестов', 'Редактор тестов');
	}

	public function actionIndex()
	{
		if ($this->isAjax()) {
			if ($_POST['action'] == 'result') {
				exit();
			}
		}
		$this->autorize();
		View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');
	}

	public function getTestId()
	{
		if (is_array($this->route)) {
			if (array_key_exists('alias', $this->route)) {
				if ($this->route['alias']) {
					return (int)$this->route['alias'];
				}
			} else {
				return 1;
			}
		}
	}

	public function actionResults()
	{
		$this->getFromCache('/results/freetest/');
	}

	public function actionDo()
	{
		$this->autorize();
		View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');

		if ($this->isAjax()) {
			$func = json_decode($_POST['param'])->action;
			Freetest::$func();
			exit();
		}
		$testId = $this->getTestId();
		$testData = Freetest::getFreetestData($testId);
		View::setJS('freeTest.js');
		View::setCss('freeTest.css');

		if ($testData === 0) {//  0 -  это папка
			$msg[] = 'Это папка! <a href = ' . PROJ . '/1>Перейти к тестам</a>';
			$error = include APP . '/view/User/alert.php'; //
			$this->set(compact('js', 'css', 'error', 'msg'));
		} elseif ($testData === FALSE) {//Теста с таким номером нет
			$msg[] = 'Теста с таким номером нет.';
			$error = include ROOT . '/app/view/Freetest/alert.php'; //
			$this->set(compact('msg', 'error'));
		}

		if ($testData) {
			$testName = $testData[0]['name'];
			$testId = $testData[0]['parent'];
			$_SESSION['freetestData'] = $testData;

			$_SESSION['key_words'] = $testData['key_words'];
			unset($testData['key_words']);
			unset($_SESSION['key_words']);
			unset($_SESSION['freetestData']);

			ob_start();
			new Pagination([
				'id' => $this->route['alias'],
				'testData' => $testData,
				'tpl' => ROOT . "/app/view/widgets/pagination/pagination_tpl/do_freetest_pagination.php",
				'cache' => 60,
				'sql' => "SELECT * FROM freetest_quest WHERE parent = ?"
			]);
			$pagination = ob_get_clean();

			ob_start();
			new Menu([
				'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/do_freetest_menu.php",
				'cache' => 60,
				'sql' => "SELECT * FROM freetest WHERE enable = '1'"
			]);
			$testsMenu = ob_get_clean();

			$this->set(compact('testData', 'testName', 'testId', 'pagination', 'testsMenu'));
		}
	}

}
