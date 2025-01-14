<?php

namespace app\controller;

use app\core\Auth;
use app\core\Mail\PHPMail;
use app\core\Request;
use app\core\Response;
use app\model\User;
use app\Repository\UserRepository;
use app\Services\YandexAuth\YaAuthService;
use app\view\User\UserView;
use Throwable;

class AuthController extends AppController
{
    protected $mailer;
    protected UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
//		$bot = new TelegramBot();
//		$bot->send('Что так');
        $this->userRepository = new UserRepository();
    }

    public function actionReturnpass(): void
    {
        $this->mailer = new PHPMail();

        if ($req = $this->ajax) {
            $_SESSION['id'] = '';
            $user           = $this->userRepository->getByEmail($req['email']);

            if ($user) {
                $newPassword    = $this->userRepository->randomPassword();
                $hashedPassword = $this->userRepository->preparePassword($newPassword);
                $this->userRepository->changePassword($user, $hashedPassword);

                try {
                    $sent = $this->mailer->sendNewPasswordMail($user, $newPassword);
                    Response::exitJson(['success' => true,
                        'popup' => 'Новый пароль проверьте на почте']);
                } catch (\Throwable $exception) {
                    Response::exitJson(['error' => 'not sent', 'popup' => 'Ошибка отправки письма']);
                }
            } else {
                Response::exitWithError("Пользователя с таким e-mail нет");
            }
        }
    }

    public function actionRegister(): void
    {
        $this->mailer = new PHPMail();
        $req          = $this->ajax;
        if ($req) {
            if (!$req) Response::exitJson(['error' => 'empty fields', 'popup' => 'Заполните поля' . "\n"]);
            if (!$req['email']) Response::exitJson(['error' => 'empty email', 'popup' => 'Заполните email' . "\n"]);
            if (!$req['password']) Response::exitJson(['error' => 'empty password', 'popup' => 'Заполните пароль' . "\n"]);

            if (!empty($this->userRepository->getByEmail($req['email']))) {
                Response::exitJson(['error' => 'mail exists',
                    'message' => 'Такая почта уже существует',
                    'popup' => 'Такая почта уже зарегистрирована. Либо войдите под своим паролем. Либо восстановите его.' . "\n"
                ]);
            }

            $user = $this->userRepository->createUser($req);
            if ($user) {
                    try {
                    $this->mailer->sendRegistrationMail($user);
                    Response::exitJson(['success' => true, 'popup' => 'Письмо с регистрацией отпрвлено на указанный Вами email']);
                } catch (Throwable $exception) {
                    Response::exitJson(['error' => true, 'popup' => 'Письмо не отправлено']);
                }

            } else {
                Response::exitJson(['error' => 'no user', 'popup' => "Пользователь не создан"]);
            }
        }
    }

    public function actionYandex(): void
    {
        $this->view = 'yandex';
        $userData   = (new YaAuthService())->getUser();
        header('Location:/');
        exit;
    }

    public function actionLogin(): void
    {
        if ($data = $this->ajax) {
            $req    = new Request();
            $errors = $req->checkLoginCredentials($data);
            if ($errors) Response::exitJson(['errors' => $errors, 'popup' => $errors]);
            $user = User::where('email', $data['email'])->with('role')->first();

            if (!$user) Response::exitJson(['errors' => 'not registered', 'popup' => 'Пройдите регистрацию']);

            if (!$user->confirm) Response::exitJson(['popup' => 'Зайдите на почту чтобы подтвердить регистрацию', 'error' => 'Зайдите на почту чтобы подтвердить регистрацию']);
            if ($user->password !== $this->userRepository->preparePassword($data['password'])) {
                Auth::setUser($user);// Если данные правильные, запоминаем пользователя (в сессию)
                if (!$user->isSU()) {
                    Response::exitWithError('Не верный email или пароль');
                }
            }
            Auth::setAuth($user);
            Auth::setUser($user);

            if ($user->isEmployee()) {
                Response::exitJson(['role' => 'employee', 'id' => $user['id']]);
            } else if ($user->isAdmin()) {
                Response::exitJson(['role' => 'guest', 'id' => $user['id']]);
            } else {
                Response::exitJson(['role' => 'guest', 'id' => $user['id']]);
            }
            $url = $this->getUrl();
            $this->setVars(compact('url'));

        }
    }

    private function getUrl(): string
    {
        if (DEV) {
            return 'https://vi-prod/auth/yandex';
        }
        return 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query(
                array(
                    'client_id' => '1cacd478c22b49c1a22e59ac811d0fc0',
                    'redirect_uri' => 'https://vitexopt.ru/auth/yandex',
                    'response_type' => 'code',
                    'state' => '123'
                )));
    }


    public function actionProfile(): void
    {
        $user = Auth::getUser();

        if ($user->isEmployee()) {
            if ($user->isAdmin()) {
                $item = UserView::admin($user);
            } else {
                $item = UserView::employee($user);
            }
        } else {
            $item = UserView::guest($user);
        }
        $this->setVars(compact('item'));
    }

    public function actionChangePassword(): void
    {
        if ($req = $this->ajax) {
            if (!$req['old_password'] || !$req['new_password'])
                Response::exitWithError('Заполните старый и новый пароль');

            $old_password = $this->userRepository->preparePassword($req['old_password']);
            $user         = $this->userRepository->getByPass($old_password);

            if ($user) {
                $user        = $user[0];
                $newPassword = $this->userRepository->preparePassword($req['new_password']);
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
            header('Location:/');
            exit();
        }

        Auth::setAuth($user);
        if ($user->update(['confirm' => 1])) {
            header('Location:/');
//            Response::exitJson(['success' => 'Вы успешно подтвердили почту', 'popup=' => 'Вы успешно подтвердили почту']);
        }
        Response::exitJson(['error' => 'Произошла ошибка', 'popup=' => 'Произошла ошибка']);
    }

    public function actionUnautherized(): void
    {
        $view = 'unautherized';
    }

    public function actionUnsubscribe(): void
    {
        $view = 'unautherized'; // для почтовой отписки
    }
//    public static function user(): array|bool
//    {
//        if (isset($_SESSION['id']) && $_SESSION['id']) return false;
//        $user = User::where('id', $_SESSION['id'])->first();
//        if (!$user) return false;
//        return $user->toArray();
//    }
}
