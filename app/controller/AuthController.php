<?php

namespace app\controller;

use app\service\Mail\PHPMail;
use app\formRequest\LoginRequest;
use app\model\User;
use app\repository\UserRepository;
use app\service\AuthService\Auth;
use app\service\Router\IRequest;
use app\service\YandexAuth\YaAuthService;
use app\view\User\UserView;
use Throwable;

class AuthController extends AppController
{
    protected $mailer;

    public function __construct(
        protected UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    public function actionLogin(LoginRequest $request): void
    {
        if ($request->validated()) {
            $req    = new LoginRequest();
            $errors = $req->checkLoginCredentials($data);
            if ($errors) response()->json(['errors' => $errors, 'popup' => $errors]);
            $user = User::where('email', $data['email'])->with('role')->first();

            if (!$user) response()->json(['errors' => 'not registered', 'popup' => 'Пройдите регистрацию']);

            if (!$user->confirm) response()->json(['popup' => 'Зайдите на почту чтобы подтвердить регистрацию', 'error' => 'Зайдите на почту чтобы подтвердить регистрацию']);
            if ($user->password !== $this->userRepository->preparePassword($data['password'])) {
                Auth::setUser($user);// Если данные правильные, запоминаем пользователя (в сессию)
                if (!$user->isSU()) {
                    response()->json(['error' => 'Не верный email или пароль']);
                }
            }
            Auth::setAuth($user);
            Auth::setUser($user);

            if ($user->isEmployee()) {
                response()->json(['role' => 'employee', 'id' => $user['id']]);
            } else if ($user->isAdmin()) {
                response()->json(['role' => 'guest', 'id' => $user['id']]);
            } else {
                response()->json(['role' => 'guest', 'id' => $user['id']]);
            }
            $url = $this->getUrl();
            $this->setVars(compact('url'));

        }
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
                    response()->json(['success' => true,
                        'popup' => 'Новый пароль проверьте на почте']);
                } catch (\Throwable $exception) {
                    response()->json(['error' => 'not sent', 'popup' => 'Ошибка отправки письма']);
                }
            } else {
                response()->json(['error' => "Пользователя с таким e-mail нет"]);
            }
        }
    }

    public function actionRegister(): void
    {
        $this->mailer = new PHPMail();
        $req          = $this->ajax;
        if ($req) {
            if (!$req) response()->json(['error' => 'empty fields', 'popup' => 'Заполните поля' . "\n"]);
            if (!$req['email']) response()->json(['error' => 'empty email', 'popup' => 'Заполните email' . "\n"]);
            if (!$req['password']) response()->json(['error' => 'empty password', 'popup' => 'Заполните пароль' . "\n"]);

            if (!empty($this->userRepository->getByEmail($req['email']))) {
                response()->json(['error' => 'mail exists',
                    'message' => 'Такая почта уже существует',
                    'popup' => 'Такая почта уже зарегистрирована. Либо войдите под своим паролем. Либо восстановите его.' . "\n"
                ]);
            }

            $user = $this->userRepository->createUser($req);
            if ($user) {
                try {
                    $this->mailer->sendRegistrationMail($user);
                    response()->json(['success' => true, 'popup' => 'Письмо с регистрацией отпрвлено на указанный Вами email']);
                } catch (Throwable $exception) {
                    response()->json(['error' => true, 'popup' => 'Письмо не отправлено']);
                }

            } else {
                response()->json(['error' => 'no user', 'popup' => "Пользователь не создан"]);
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
        if (Auth::userIsAdmin()) {
            $item = Auth::userIsEmployee()
                ? UserView::admin($user)
                : UserView::employee($user);
        } else {
            $item = UserView::guest($user);
        }
        view('profile.index', compact('item'));
    }

    public function actionChangePassword(): void
    {
        if ($req = $this->ajax) {
            if (!$req['old_password'] || !$req['new_password'])
                response()->json(['error' => 'Заполните старый и новый пароль']);

            $old_password = $this->userRepository->preparePassword($req['old_password']);
            $user         = $this->userRepository->getByPass($old_password);

            if ($user) {
                $user        = $user[0];
                $newPassword = $this->userRepository->preparePassword($req['new_password']);
                $res         = User::where('id', $user['id'])
                    ->update(['password' => $newPassword]);
                if ($res) {
                    response()->json(['success' => 'Пароль поменeн']);
                } else {
                    response()->json(['msg' => 'Что-то пошло не так (']);
                }
            } else {
                response()->json(['error' => 'Не правильный старый пароль (']);
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
        response()->json(["response" => 'logout']);
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
        response()->json(['error' => 'Произошла ошибка', 'popup=' => 'Произошла ошибка']);
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
