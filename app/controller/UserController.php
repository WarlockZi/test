<?php

namespace app\controller;

use app\core\Base\View;
use app\core\Base\Controller;
use app\model\User;
use app\core\App;

class UserController extends AppController {

   public function __construct($route) {
      parent::__construct($route);
      $css = 'style.css';
      $this->set(compact('css'));
   }

   public function actionContacts() {

      $this->auth();
      if (isset($_POST['token'])) {
         if ($_SESSION['token'] !== $_POST['token']) {
            echo $_POST['token'] . '  +  +  ' . $_SESSION['token'];
            exit('Обновите страницу.');
         }
      }
      View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
   }

   public function actionLogin() {

      if ($this->isAjax()) {

         if (isset($_POST['token'])) {
            if ($_SESSION['token'] !== $_POST['token']) {
               $msg[] = "Обновите страницу";
               echo include APP . '/view/User/alert.php';
               exit('Обновите страницу');
            }
         }


         $email = $_POST['email'];
         $password = $_POST['password'];

         if (!App::$app->user->checkEmail($email)) {
            $msg[] = "Неверный формат email";
            echo include APP . '/view/User/alert.php';
            exit();
         }
         if (!App::$app->user->checkPassword($password)) {
            $msg[] = "Пароль не должен быть короче 6-ти символов";
            echo include APP . '/view/User/alert.php';
            exit();
         }

         // Проверяем существует ли пользователь и подтвердил ли регистрацию
         $user = App::$app->user->getUserByEmail($email, $password);
         $user['rightId'] = explode(",", $user['rightId']);
         // Почта с паролем существуют, но нет подтверждения
         if ($user === false) {
            // Нет пользователя с таким паролем
            $msg[] = "Пользователь с 'e-mail' : $email не зарегистрирован";
            $msg[] = "Перейдите по <a href = 'https://vitexopt.ru" . PROJ . "/user/register'>ССЫЛКЕ</a> чтобы зарегистрироваться.";
            echo include APP . '/view/User/alert.php';
            exit();
         } elseif ($user === NULL) {
            // Пароль, почта в порядке, но нет подтверждения
            $msg[] = 'Зайдите на <a href ="https://mail.vitexopt.ru/webmail/login/">РАБОЧУЮ ПОЧТУ</a>, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
            echo include APP . '/view/User/alert.php';
            exit();
         } else {
            // Если данные правильные, запоминаем пользователя (в сессию)
            App::$app->user->setAuth($user);

            // Перенаправляем пользователя в закрытую часть - кабинет
//            if (in_array('5', explode(",", $user['rightId'])) && !in_array('2', explode(",", $user['rightId']))) {
//
//               echo 'squash';
//               exit();
//            }
            echo 'true';
            exit();
         }
      }

      View::setMeta('Авторизация', 'Авторизация', 'Авторизация');

      if (isset($_SESSION['id'])) {
         $user = App::$app->user->getUserById($_SESSION['id']);
      }

      $token = $this->token;
      $js = $this->getJSCSS('.js');
      $this->set(compact('js', 'user', 'token'));
   }

   public function actionRegister() {

      if ($this->isAjax()) {

         if (isset($_POST['token'])) {
            if ($_SESSION['token'] !== $_POST['token']) {
               exit('Обновите страницу');
            }
         }

         $email = App::$app->user->clean_data($_POST['email']); //$post['reg_email'];//
         $password = App::$app->user->clean_data($_POST['password']);
         $confPass = App::$app->user->clean_data($_POST['confPass']);
         $name = App::$app->user->clean_data($_POST['name']); //$post['reg_name'];//
         $surName = App::$app->user->clean_data($_POST['surName']); //$post['reg_name'];//
         $secName = App::$app->user->clean_data($_POST['secName']); //$post['reg_name'];//

         if ($msg = $this->regDataWrong($email, $password, $confPass, $name, $surName, $secName)) {
            echo include APP . '/view/User/alert.php';
            exit();
         }

         $password = md5($password);
         $hash = md5(microtime());
         $squash = (isset($_SESSION['back_url']) && $_SESSION['back_url'] == 'squash') ? 1 : 0;


         $sql = 'INSERT INTO users (squa, rightId, surName, middleName, name, email, password, hash)'
            . 'VALUES (?,?,?,?,?,?,?,?)';
         $params = [$squash, 2, $surName, $secName, $name, $email, $password, $hash];

         $res = App::$app->user->insertBySql($sql, $params);

         if (!$res) {
            $msg[] = "Ошибка при добавлении пользователя в базу данных";
            echo include APP . '/view/User/alert.php';
            exit();
         }

         // Все прошло гладко. Отправим почту.
         $headers = "Content-Type: text/plain; charset=utf8";
//         $headers .= "From: Admin <admin@mail.ru> \r\n";
         $tema = "Регистрация VITEX";
         $mail_body = "Для продолжения работы перейдите по ссылке: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . PROJ . "/user/confirm?hash=" . $hash;
//         mail('', $tema, $mail_body, $headers);
         App::$app->user->send_mail($email, $tema, $mail_body, $headers);



         $msg[] = "Для подтвержения регистрации перейдите по ссылке в <br><a href ='https://mail.vitexopt.ru/webmail/login/'>ПОЧТЕ</a>.<br>Письмо может попасть в папку 'Спам'";
         echo include APP . '/view/User/alert.php';
         exit();
      }
      View::setMeta('Регистрация', 'Регистрация', 'Регистрация');
      $token = $this->token;
      $js = $this->getJSCSS('.js');
      $this->set(compact('js','token'));
   }

   public function regDataWrong($email, $password, $confPass, $name, $surName, $secName) {

      if (isset($_POST)) {

         $msg = [];
         if (empty($password)) {
            $msg[] = "Введите пароль.";
         }
         if (empty($email)) {
            $msg[] = "Введите адрес почтового ящика.";
         }
         if (!App::$app->user->checkEmail($email) && !empty($email)) {
            $msg[] = "Введите правильный адрес почтового ящика.";
         }
         if (empty($name)) {
            $msg[] = "Введите имя.";
         }
         if (empty($surName)) {
            $msg[] = "Введите фамилию.";
         }
         if (empty($secName)) {
            $msg[] = "Введите отчество.";
         }
         if ($confPass != $password) {
            $msg[] = "Вы не правильно подтвердили пароль";
         }
         // Если есть пользователь с таким email.
         if (App::$app->user->checkEmailExists($email)) {
            $msg[] = "Пользователь с таким e-mail уже существует<br>"
               . "Перейдите по ссылке, чтобы получить пароль на эту почту. <br>"
               . "<a href='" . PROJ . "/user/returnpass'>Забыли пароль</a>";
         }
         if ($msg) {//есть ошибки
            return $msg;
         }
      }
      return false;
   }

   public function actionLogout() {

      if (isset($_COOKIE[session_name()])) {  // session_name() - получаем название текущей сессии
         setcookie(session_name(), '', time() - 86400, '/');
      }
      //очистить массив  $_SESSION
      $_SESSION = array();

      session_destroy();

      // Перенаправляем пользователя на главную страницу
      header("Location: /");
   }

   public function actionConfirm() { // Забишем что пользователь подтвердил почту в базу данных
      // Получим id пользователя по hash
      try {
         $hash = App::$app->user->clean_data($_GET['hash']);
         if (!$hash) {
            throw new \Exception();
         }
      } catch (\Exception $e) {
         header('Location:/');
         exit();
      };

      if (!App::$app->user->confirm($hash)) {
         exit('Не удалось подтвердить почту');
      };
      $user = App::$app->user->getUserByHash($hash);
      // Сохраним id пользователя в сессии
      App::$app->user->setAuth($user);

      View::setMeta('Проверка почты', 'Почта пользователя проверена', 'проверка почты');

      $rightId = explode(",", $user['rightId']);
      $js = $this->getJSCSS('.js');
      $this->set(compact('user', 'rightId'));
//      if (isset($_GET['squash']) && $_GET['squash'] == "1") {
//         header('Location:/test2/squash');
//         exit();
//      }
   }

   public function actionReturnPass() {

      $_SESSION['id'] = '';
      App::$app->user->returnPass();

      View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
      $this->set(compact('user'));
   }

   public function actionCabinet() {

      $this->auth(); // Авторизация
      // Проверяем существует ли пользователь и подтвердил ли регистрацию
      $user = App::$app->user->getUserWithRightsSet($_SESSION['id']);

      if ($this->vars['user'] === false) {
         // Если пароль или почна неправильные - показываем ошибку
         $errors[] = 'Неправильные данные для входа на сайт';
      } elseif ($this->vars['user'] === NULL) {
         // Пароль почта в порядке, но нет подтверждения
         $errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
      } else {
         View::setMeta('Спецодежда оптом с доставкой', 'Доставим спецодежду в любую точку России', 'Спецодежда, доставка, производство, по России');
//         $rightId = explode(",", $user['rightId']);
//         $this->set(compact('user'));
      }
   }

   public function actionEdit() {
      $this->auth(); // Авторизация
      // Получаем идентификатор пользователя из сессии, если есть
      if (App::$app->user->userId()) {
         $userId = App::$app->user->userId();
      }
      // Получаем информацию о пользователе из БД
      $user = App::$app->user->getUserById($userId);

      // Флаг результата
      $result = false;

      // Обработка формы
      if (isset($_POST['submit'])) { //нажали кнопку сохранить
         // Если форма отправлена
         // Получаем данные из формы редактирования
         $email = $user['email'] = App::$app->user->clean_data($_POST['email']);
         $name = $user['name'] = App::$app->user->clean_data($_POST['name']);
         $surName = $user['surName'] = App::$app->user->clean_data($_POST['surName']);
         $middleName = $user['middleName'] = App::$app->user->clean_data($_POST['middleName']);
         $birthDate = $user['birthDate'] = App::$app->user->clean_data($_POST['birthDate']);
         $phone = $user['phone'] = App::$app->user->clean_data($_POST['phone']);
         $password = $user['password'] = $_POST['password'];

         $errors = false;

         if (!App::$app->user->checkName($name)) {
            $errors[] = 'Имя не должно быть короче 2-х символов';
         }
         if (!App::$app->user->checkPassword($password)) {
            $errors[] = 'Пароль не должен быть короче 6-ти символов';
         }

         if ($errors == false) {
            // Если ошибок нет, сохраняет изменения профиля
            $result = App::$app->user->update($userId, $email, $name, $surName, $middleName, $birthDate, $phone, $password);
         }
         View::setMeta('Профиль', 'Профиль', 'Профиль');
         $css = 'style.css';
         $rightId = explode(",", $user['rightId']);
         $this->set(compact('css', 'user', 'rightId', 'result', 'errors'));
      } else {// форма из базы данных
         $email = $user['email'];
         $name = $user['name'];
         $surName = $user['surName'];
         $middleName = $user['middleName'];
         $birthDate = $user['birthDate'];
         $phone = $user['phone'];
         $password = $user['password'];

         View::setMeta('Профиль', 'Профиль', 'Профиль');
//         $rightId = explode(",", $user['rightId']);
         $this->set(compact('user', 'rightId'));
      }
   }

}
