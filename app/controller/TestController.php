<?php

namespace app\controller;

use app\model\User;
use app\model\Test;
use app\core\Base\View;
use app\view\widgets\menu\Menu;
use app\core\App;

class TestController Extends AppController {

//   public function __construct($route) {
//
//      if ($this->isAjax()) {
//         if (isset($_POST['param'])) {
//            $arr = json_decode($_POST['param'], true);
//            $func = $arr['action'];
//            App::$app->test->$func($arr);
//            exit();
//         };
//      };
//   }

   public function actionIndex() {

      $this->auth();
      View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
   }

   public function actionEdit() {

      //Если пользователь не авторизовался отправим на форму авторизации
      $this->auth();

      // Загрузка картинок drag-n-drop
      if (isset($_FILES['file']) && !empty($_FILES['file'])) {
         App::$app->test->QPic();
         exit();
      } elseif ($this->isAjax()) {
         $func = $_POST['action'];
         App::$app->test->$func();
         exit();
      }

      //Получим id теста
      if (is_array($this->route)) {
         if (array_key_exists('alias', $this->route)) {
            if ($this->route['alias']) {
               $testId = (int) $this->route['alias'];
            }
         } else {
            $testId = 1;
         }
      }

      $testDataToEdit = App::$app->test->getTestDataToEdit($testId);
      $css = 'style.css';

      if ($testDataToEdit === FALSE) {//Вообще не нашли такого теста с номером
         $error = '<H1>Теста с таким номером нет.</H1>';
         $this->set(compact('css', 'error'));
      }

      if ($testDataToEdit) {
         $js = $this->getJSCSS('.js');
         $pagination = App::$app->test->paginationEdit($testDataToEdit, $testId);
         $this->set(compact('css', 'testDataToEdit', 'pagination', 'testId', 'js'));
      }
      View::setMeta('Редактор тестов', 'Редактор тестов', 'Редактор тестов');
   }

   public function actionResults() {

      $this->getFromCache('/results/test/');
      exit();
      $this->auth();
      View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');

      if (is_array($this->route)) {
         if (array_key_exists('cache', $this->route)) {
            if ($this->route['cache']) {
               $cache = $this->route['cache'];
            }
         }
      }

      $file = CACHE . '/results/' . $cache . '.txt';

      if (file_exists($file)) {

         $results = require $file;
      }
      $this->set(compact('results'));
      exit();
   }

   public function actionDo() {

      //Если пользователь не авторизовался отправим на форму авторизации
      $this->auth();
      $css = 'style.css';
      $js = $this->getJSCSS('.js');
      View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');


      //Получим id теста
      if (is_array($this->route)) {
         if (array_key_exists('alias', $this->route)) {
            if ($this->route['alias']) {
               $testId = (int) $this->route['alias'];
            }
         } else {
            $testId = 1;
         }
      }
      //Получим данные теста
      $testData = App::$app->test->getTestData($testId);
      $_SESSION['testData'] = $testData;

      if ($testData === 0) {//  0 - это просто альтернатива FALSE это папка
         $msg[] = 'Это папка! <a href = ' . PROJ . '/1>Перейти к тестам</a>';
         $error = include APP . '/view/User/alert.php'; //
         $script = include APP . '/view/User/alertScript.js';
         $this->set(compact('css', 'js', 'error', 'msg'));
      } elseif ($testData === FALSE) {//Теста с таким номером нет
         $error = '<H1>Теста с таким номером нет.</H1>';
         $this->set(compact('js', 'css', 'error'));
      } elseif ($testData) {// запоминаем данные в  сессии для расчета результатов
         $testName = $testData['test_name'];
         unset($testData['test_name']);
         $testId = $testData['testId'];
         unset($testData['testId']);
         $_SESSION['correct_answers'] = $testData['correct_answers'];
         unset($testData['correct_answers']);
         unset($_SESSION['correct_answers']);
         unset($_SESSION['testData']);
         $pagination = App::$app->test->pagination($testData);
         $this->set(compact('css', 'js', 'testData', 'pagination', 'testName', 'testId'));
      }
   }

}
