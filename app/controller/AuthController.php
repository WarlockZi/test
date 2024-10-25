<?php

namespace app\controller;

use app\core\Auth;
use app\core\Mail\PHPMail;
use app\core\Request;
use app\core\Response;
use app\model\User;
use app\Repository\UserRepository;
use app\view\User\UserView;

class AuthController extends AppController
{
    protected PHPMail $mailer;
    protected UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
//		$bot = new TelegramBot();
//		$bot->send('Что так');

        $this->userRepository = new UserRepository();
        $this->mailer         = new PHPMail('env');
    }

    public function actionRegister(): void
    {
        $req = $this->ajax;
        if ($req) {

            if (!$req) Response::exitJson(['error' => 'empty fields', 'popup' => 'Заполните поля' . "\n"]);
            if (!$req['email']) Response::exitJson(['error' => 'empty email', 'popup' => 'Заполните email' . "\n"]);
            if (!$req['password']) Response::exitJson(['error' => 'empty password', 'popup' => 'Заполните password' . "\n"]);

            if (User::where('email', $req['email'])->first())
                Response::exitJson([
                    'error' => 'email exists',
                    'popup' => 'Такая почта уже зарегистрирована. Либо войдите под своим паролем. Либо восстановите его.' . "\n"
                ]);

            $user = $this->userRepository->createUser($req);
            if ($user) {
                $message = "Пользователь создан\n";
                $sent    = $this->mailer->sendRegistrationMail($user);
                if ($sent) {
                    Response::exitJson(['success' => 'confirm', 'popup' => $message . "\n" . $sent]);
                } else {
                    $message .= "Письмо не отправлено";
                    Response::exitJson(['error' => 'not sent', 'popup' => $message . "\n" . $sent]);
                }
            } else {
                Response::exitJson(['error' => 'no user', 'popup' => "Пользователь не создан"]);
            }
        }
    }

    public function actionLogin(): void
    {
        if ($data = $this->ajax) {

            $req    = new Request();
            $errors = $req->checkLoginCredentials($data);
            if ($errors) Response::exitJson(['errors' => $errors, 'popup' => $errors]);
            $user = User::where('email',$data['email'])->first();

            if (!$user) Response::exitJson(['errors' => 'not registered', 'popup' => 'Пройдите регистрацию']);

            if (!$user->confirm) Response::exitWithSuccess('Зайдите на почту чтобы подтвердить регистрацию');
            if ($user->password !== $this->userRepository->preparePassword($data['password'])) {
                Auth::setUser($user);
                if (!Auth::isSU()) {
                    Response::exitWithError('Не верный email или пароль');// Если данные правильные, запоминаем пользователя (в сессию)
                }
            }
            Auth::setAuth($user);
            Auth::setUser($user);

            if ($user->can(['role_employee'])) {
                Response::exitJson(['role' => 'employee', 'id' => $user['id']]);
            } else {
                Response::exitJson(['role' => 'user', 'id' => $user['id']]);
            }
        }

        $params = array(
            'client_id' => '1cacd478c22b49c1a22e59ac811d0fc0',
            'redirect_uri' => 'https://vitexopt.ru/auth/yandexauth',
            'response_type' => 'token',
            'state' => '123'
        );

        $url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));

        $this->setVars(compact('url'));
        $this->view = 'login';
    }


    public function actionProfile(): void
    {
        $user = Auth::getUser();

        if ($user->can(['role_employee'])) {
            if ($user->can(['role_admin'])) {
                $item = UserView::admin($user);
            } else {
                $item = UserView::employee($user);
            }

        } else {
            $item = UserView::guest($user);;
        }

        $this->setVars(compact('item'));
    }

    public function actionChangePassword(): void
    {
        if ($data = $this->ajax) {
            if (!$data['old_password'] || !$data['new_password'])
                Response::exitWithError('Заполните старый и новый пароль');

            $old_password = $this->userRepository->preparePassword($data['old_password']);

            $user = User::where('password', $old_password)
                ->get()->toArray();

            if ($user) {
                $user        = $user[0];
                $newPassword = $this->userRepository->preparePassword($data['new_password']);
                $res         = User::where('id', $user['id'])
                    ->update(['password' => $newPassword]);
                if ($res) {
                    Response::exitWithSuccess('Пароль поменeн');
                } else {
                    Response::exitWithMsg('Что-то пошло не так (');
                }
            } else {
                Response::exitWithError('Не правильный старый пароль (');
            }
        }
    }

    public function actionReturnpass(): void
    {
        if ($data = $this->ajax) {
            $_SESSION['id'] = '';
            $user           = $this->userRepository->returnPassword($data);

            if ($user) {
                $password    = $this->userRepository->randomPassword();
                $newPassword = $this->userRepository->preparePassword($password);
                User::where('id', $user['id'])
                    ->update(['password' => $newPassword]);

                $this->mailer->returnPassword($data);
                Response::exitWithSuccess('Новый пароль проверьте на почте');
            } else {
                Response::exitWithError("Пользователя с таким e-mail нет");
            }
        }
    }


    public function actionLogout(): void
    {
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 86400, '/');
        }
        unset($_SESSION);
        header("Location: /");
        Response::exitJson(["response" => 'logout']);
    }


    public function actionConfirm(): void
    {
        $hash = $this->route->id;

        if (!$hash) header('Location:/');
        $user = User::where('hash', $hash)->first();

        if (!$user) {
            header('Location:/auth/login');
            exit();
        }

        $user['confirm'] = "1";
        Auth::setAuth($user);
        if ($user->update()) {
            header('Location:/auth/success');
            Response::exitWithPopup('"Вы успешно подтвердили свой E-mail."');
        }
    }


    public static function user(): array|bool
    {
        if (isset($_SESSION['id']) && $_SESSION['id']) return false;

        $user = User::where('id', $_SESSION['id'])->first();
        if (!$user) return false;

        return $user->toArray();

    }

    public function actionUnautherized(): void
    {
        $view = 'unautherized';
    }

    public function actionUnsubscribe(): void
    {
        $view = 'unautherized'; // для почтовой отписки
    }
}
