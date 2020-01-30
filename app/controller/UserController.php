<?php

namespace app\controller;

use app\core\Base\View;
use app\core\Base\Controller;
use app\model\User;
use app\core\App;

class UserController extends AppController
{

    public function __construct($route)
    {
//      if ($this->isAjax()) {
//         if (isset($_POST['param'])) {
//            $arr = json_decode($_POST['param'], true);
//            if (!isset($arr['token']) || !$arr['token'] == $_SESSION['token']) {
//               exit(FALSE);
//            }
//            $func = $arr['action'];
//            $model = $arr['model'] ?: 'adminsc';
//            if (App::$app->{$model}->$func($arr)) {
//               exit('true');
//            }
//         }
//      }
        parent::__construct($route);
        View::setCss([
            'css' => '/public/css/vitex.css',
            'addtime'
        ]);
    }

    public function actionContacts()    {
        $this->auth();
        if (isset($_POST['token'])) {
            if ($_SESSION['token'] !== $_POST['token']) {
                echo $_POST['token'] . '  +  +  ' . $_SESSION['token'];
                exit('Обновите страницу.');
            }
        }
        View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
    }

    public function actionCabinet()
    {
        $this->auth(); // Авторизация

        if ($this->vars['user'] === false) {
            // Если пароль или почна неправильные - показываем ошибку
            $errors[] = 'Неправильные данные для входа на сайт';
        } elseif ($this->vars['user'] === NULL) {
            // Пароль почта в порядке, но нет подтверждения
            $errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
        } else {
            View::setMeta('Личный кабинет', 'Личный кабинет', '');
        }
    }
    public function actionLogin()
    {
        if ($data = $this->isAjax()) {
            $email = (string)$data['email'];
            $password = (int)$data['pass'];
            if (!App::$app->user->checkEmail($email)) {
                $msg[] = "Неверный формат email";
                exit(include APP . '/view/User/alert.php');
            }
            if (!App::$app->user->checkPassword($password)) {
                $msg[] = "Пароль не должен быть короче 6-ти символов";
                exit(include APP . '/view/User/alert.php');
            }
            $user = App::$app->user->getUserByEmail($email, $password);
            if ($user === false) { // Почта с паролем существуют, но нет подтверждения
                // Нет пользователя с таким паролем
                $msg[] = "Пользователь с 'e-mail' : $email не зарегистрирован";
                $msg[] = "Перейдите по <a href = 'https://vitexopt.ru" . PROJ . "/user/register'>ССЫЛКЕ</a> чтобы зарегистрироваться.";
                exit(include APP . '/view/User/alert.php');
            } elseif ($user === NULL) {// Пароль, почта в порядке, но нет подтверждения
                $msg[] = 'Зайдите на <a href ="https://mail.vitexopt.ru/webmail/login/">РАБОЧУЮ ПОЧТУ</a>, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
                echo include APP . '/view/User/alert.php';
                exit();
            } else {// Если данные правильные, запоминаем пользователя (в сессию)
                $user['rights'] = explode(",", $user['rights']);
                App::$app->user->setAuth($user);

                $this->set(compact('user'));
                $msg[] = "Все ок";
                exit(include APP . '/view/User/alert.php');
            }
        }
        if (isset($_SESSION['id'])) {
            $user = App::$app->user->getUser($_SESSION['id']);
            $this->set(compact('user'));
        }
//        View::setJs(['controller' => $this->route['controller'],'view' => $this->view,'addtime']);

    }

    public function actionRegister()
    {

        if ($this->isAjax()) {

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


            $sql = 'INSERT INTO users (rightId, surName, middleName, name, email, password, hash)'
                . 'VALUES (,?,?,?,?,?,?,?)';
            $params = [2, $surName, $secName, $name, $email, $password, $hash];

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
        View::setCss(['css' => $this->route['controller'], 'view' => $this->view, 'addtime']);
        $this->set(compact('token'));
    }

    public function regDataWrong($email, $password, $confPass, $name, $surName, $secName)
    {

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

    public function actionLogout()
    {

        if (isset($_COOKIE[session_name()])) {  // session_name() - получаем название текущей сессии
            setcookie(session_name(), '', time() - 86400, '/');
        }
        //очистить массив  $_SESSION
        $_SESSION = array();

        session_destroy();

        // Перенаправляем пользователя на главную страницу
        header("Location: /");
    }

    public function actionConfirm()
    { // Забишем что пользователь подтвердил почту в базу данных
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

        $rightId = explode(",", $user['rights']);
        $js = $this->getJSCSS('.js');
        $this->set(compact('user', 'rightId'));
//      if (isset($_GET['squash']) && $_GET['squash'] == "1") {
//         header('Location:/test2/squash');
//         exit();
//      }
    }

    public function actionReturnPass()
    {

        $_SESSION['id'] = '';
        App::$app->user->returnPass();

        View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
        $this->set(compact('user'));
    }



    public function actionEdit()
    {
        $this->auth(); // Авторизация $_SESSION['id']
        // Получаем идентификатор пользователя из сессии, если есть
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
        }
        // Получаем информацию о пользователе из БД
        $user = App::$app->user->getUser($userId);

        // Флаг результата
        $result = false;

        // Обработка формы
        if (isset($_POST['submit'])) { //нажали кнопку сохранить
            // Если форма отправлена
            // Получаем данные из формы редактирования

            $ff['table'] = 'users';
            $ff['pkey'] = 'id';
            $ff['pkeyVal'] = $user['id'];
            $ff['values']['email'] = App::$app->user->clean_data($_POST['email']);
            $ff['values']['name'] = App::$app->user->clean_data($_POST['name']);
            $ff['values']['surName'] = App::$app->user->clean_data($_POST['surName']);
            $ff['values']['middleName'] = App::$app->user->clean_data($_POST['middleName']);
            $ff['values']['birthDate'] = App::$app->user->clean_data($_POST['birthDate']);
            $ff['values']['phone'] = App::$app->user->clean_data($_POST['phone']);

            $errors = false;

            if (!App::$app->user->checkName(App::$app->user->clean_data($_POST['name']))) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if ($errors == false) {
                // Если ошибок нет, сохраняет изменения профиля
                $result = App::$app->user->update($ff);
            }
            View::setMeta('Профиль', 'Профиль', 'Профиль');
            $css = 'style.css';
//            $rightId = explode(",", $user['rights']);
            $this->set(compact('css', 'user', 'result', 'errors'));
        } else {// форма из базы данных
            $email = $user['email'];
            $name = $user['name'];
            $surName = $user['surName'];
            $middleName = $user['middleName'];
            $birthDate = $user['birthDate'];
            $phone = $user['phone'];
//            $password = $user['password'];

            View::setMeta('Профиль', 'Профиль', 'Профиль');
//         $rightId = explode(",", $user['rights']);
            $this->set(compact('user'));
        }
    }

}
