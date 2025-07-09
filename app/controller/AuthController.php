<?php

namespace app\controller;

use app\formRequest\LoginRequest;
use app\formRequest\RegisterRequest;
use app\model\User;
use app\repository\UserRepository;
use app\service\AuthService\Auth;
use app\service\Mail\PHPMail;
use app\service\Router\IRequest;
use app\service\YandexAuth\YaAuthService;
use app\view\User\UserView;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;
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

    /**
     * @throws ValidationException
     */
    #[NoReturn] public function actionLogin(LoginRequest $request): void
    {
        $validated = $request->validate();

        $user = User::where('email', $validated['email'])->with('role')->first();

        if (!$user) response()->json(['errors' => 'not registered', 'popup' => 'Пройдите регистрацию']);

        if (!$user->confirm) response()->json(['popup' => 'Зайдите на почту чтобы подтвердить регистрацию', 'error' => 'Зайдите на почту чтобы подтвердить регистрацию']);
        if ($user->password !== $this->userRepository->preparePassword($validated['password'])) {
            Auth::setUser($user);// Если данные правильные, запоминаем пользователя (в сессию)
            if (!$user->isSU()) {
                response()->json(['error' => 'Не верный email или пароль']);
            }
        }
        Auth::setAuth($user);
        Auth::setUser($user);

        if ($user->isEmployee()) {
            response()->json(['role' => 'employee', 'id' => $user['id']]);
//            response()->redirect('adminsc');
        } else if ($user->isAdmin()) {
            response()->json(['role' => 'admin', 'id' => $user['id']]);
        } else {
//            response()->redirect('auth/profile');
            response()->json(['role' => 'guest', 'id' => $user['id']]);
        }
//        view('auth.login');
//        $url = $this->getUrl();
//        $this->setVars(compact('url'));
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

    public function actionRegister(RegisterRequest $request): void
    {
        $request = $request->validate();
        if (!empty($this->userRepository->getByEmail($request['email']))) {
            response()->json(['error' => 'mail exists',
                'message' => 'Такая почта уже существует',
                'popup' => 'Такая почта уже зарегистрирована. Либо войдите под своим паролем. Либо восстановите его.' . "\n"
            ]);
        }

        $user = $this->userRepository->createUser($request);
        if (!$user) response()->json(['error' => 'no user', 'popup' => "Пользователь не создан"]);
        try {
        $this->mailer = new PHPMail();
            $this->mailer->sendRegistrationMail($user);
            response()->json(['success' => true, 'popup' => 'Письмо с регистрацией отпрвлено на указанный Вами email']);
        } catch (Throwable $exception) {
            response()->json(['error' => true, 'popup' => 'Письмо не отправлено'], 201);
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


    #[NoReturn] public function actionProfile(): void
    {
        $user = Auth::getUser();
        if (!$user) {
            response()->redirect('/');
            exit();
        }

        if ($user->isAdmin() || $user->isEmployee()) {
            $catItem = UserView::employee($user);
            view('admin.profile.profile', compact('catItem'));
        } else {
            $catItem = UserView::guest($user);
            view('profile.profile', compact('catItem'));
        }
//        UserView::admin($user)
//                : UserView::employee($user  );
//        $item = UserView::guest($user);
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
                $res         = User::where('id', $user['id'])->update(['password' => $newPassword]);
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
        response()->back();
    }


    public function actionConfirm(IRequest $request): void
    {
        if (!$request->id) header('Location:/');

        $user = User::where('hash', $request->id)->first();
        if (!$user) {
            header('Location:/');
            exit();
        }

        Auth::setAuth($user);
        if ($user->update(['confirm' => 1])) {
            header('Location:/');
        }
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
