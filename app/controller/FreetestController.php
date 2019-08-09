<?php

namespace app\controller;

use app\core\Base\View;
use app\model\Freetest;
use app\controller\AppController;
use app\core\App;

class FreetestController extends AppController {

   public function actionEdit() {

      //Если пользователь не авторизовался отправим на форму авторизации
      $this->auth();

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
               $testId = (int) $this->route['alias'];
            }
         } else {
            $testId = 1;
         }
      }

      $freeTestDataToEdit = $Freetest->getFreeTestDataToEdit($testId);
      $css = 'style.css';
      $js = $this->getJSCSS('.js');

      if ($freeTestDataToEdit === FALSE) {//Вообще не нашли такого теста с номером
         $error = '<H1>Теста с таким номером нет.</H1>';
         $this->set(compact('error'));
      }

      if ($freeTestDataToEdit) {
         $pagination = $Freetest->paginationEdit($freeTestDataToEdit, $testId);
         $this->set(compact('js', 'css', 'freeTestDataToEdit', 'pagination', 'testId'));
      }
      View::setMeta('Редактор тестов', 'Редактор тестов', 'Редактор тестов');
   }

   public function actionIndex() {
      // Обработка результатов теста
      if ($this->isAjax()) {
         if ($_POST['action'] == 'result') {
            $Test->result();
            exit();
         }
      }
      $this->auth();
      View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');
   }

   public function getTestId() {
      if (is_array($this->route)) {
         if (array_key_exists('alias', $this->route)) {
            if ($this->route['alias']) {
               return (int) $this->route['alias'];
            }
         } else {
            return 1;
         }
      }
   }

   public function actionResults() {

      $this->getFromCache('/results/freetest/');
   }

   public function actionDo() {

      $this->auth();
      View::setMeta('Свободный тест', 'Свободный тест', 'Свободный тест');

      if ($this->isAjax()) {
         $func = json_decode($_POST['param'])->action;
         App::$app->freetest->$func();
         exit();
      }
      $testId = $this->getTestId();
      $testData = App::$app->freetest->getFreetestData($testId);
      $css = 'style.css';
      $js = $this->getJSCSS('.js');

      if ($testData === 0) {//  0 -  это папка
         $msg[] = 'Это папка! <a href = ' . PROJ . '/1>Перейти к тестам</a>';
         $error = include APP . '/view/User/alert.php'; //
         $this->set(compact('js', 'css', 'error', 'msg'));
      } elseif ($testData === FALSE) {//Теста с таким номером нет
         $msg[] = 'Теста с таким номером нет.';
         $error = include APP . '/view/Freetest/alert.php'; //
         $this->set(compact('js', 'css', 'msg', 'error'));
      }

      if ($testData) {
         $testName = $testData[0]['name'];

         $testId = $testData[0]['parent'];

         $_SESSION['freetestData'] = $testData;

         $_SESSION['key_words'] = $testData['key_words'];
         unset($testData['key_words']);
         unset($_SESSION['key_words']);
         unset($_SESSION['freetestData']);

         $this->set(compact('js', 'css', 'testData', 'testName', 'testId'));
      }
   }

}
