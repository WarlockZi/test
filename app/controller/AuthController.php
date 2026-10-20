<?php

namespace app\controller;

use app\action\AuthActions;
use app\formRequest\ChangePasswordRequest;
use app\formRequest\LoginRequest;
use app\formRequest\RegisterRequest;
use app\formRequest\ReturnPassRequest;
use app\model\User;
use app\repository\UserRepository;
use app\repository\UserYandexRepository;
use app\service\AuthService\AuthService;
use app\service\AuthService\AuthYandexService;
use app\service\Mail\PHPMailService;
use app\service\PasswordGenerator\PasswordGeneratorService;
use app\service\Router\IRequest;
use app\view\User\UserView;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class AuthController extends AppController
{
    public function __construct(
        protected AuthActions    $actions,
        protected PHPMailService $mailer,
        protected UserRepository $userRepository,

    )
    {
        parent::__construct();
    }

    #[NoReturn]
    public function actionLogin(LoginRequest $request, AuthActions $actions): void
    {
        $validated = $request->safe()->only('email', 'password');
        $user      = $actions->checkLoginPasswordConfirm($validated);
        AuthService::login($user);

        if ($user->isEmployee()) {
            response()->json(['role' => 'employee', 'id' => $user['id']]);
        } else if ($user->isAdmin()) {
            response()->json(['role' => 'admin', 'id' => $user['id']]);
        }
        response()->json(['role' => 'guest', 'id' => $user['id']]);
    }

    public function actionYandex(AuthYandexService $service): void
    {
        if (isset($_GET['state'])) {
            $service->checkYandexResponseState();
            setcookie('yandex_oauth_state', '', time() - 3600, '/');
            $yandexProfile = $service->exchangeCode();
            $userYandex    = UserYandexRepository::getByEmail($yandexProfile['default_email'], ['*'], ['role']);
            AuthService::login($userYandex);
            response()->redirect($_SESSION['yandex_oauth_back_url'] ?? '/');
        }
        $_SESSION['yandex_oauth_back_url'] = $_SERVER['HTTP_REFERER'];
        $service->getYandexCode();
    }

    public function actionConfirm(IRequest $request): void
    {
        if (!$request->id) header('Location:/');

        $user = User::where('hash', $request->id)->first();
        if (!$user) {
            response()->redirect('/');
        }

        if ($user->update(['confirm' => 1])) {
            AuthService::login($user);
            response()->redirect('/');
        }
    }

    public function actionReturnpass(ReturnPassRequest $request): void
    {
        $req = $request->validated();

        session()->nullify('id');
        $user = $this->userRepository->getByEmail($req['email']);

        if (!$user) {
            response()->json([
                'error' => "Пользователя с таким e-mail нет",
                'message' => "Пользователя с таким e-mail нет",
            ]);
        }

        $newPassword = PasswordGeneratorService::generate();
        $this->userRepository->changePassword($user, $newPassword);

        try {
            $sent = $this->mailer->sendNewPasswordMail($user, $newPassword);
            if ($sent) {
                response()->json(['success' => true,
                    'popup' => 'Новый пароль проверьте на почте',
                    'message' => 'Новый пароль проверьте на почте',
                ]);
            }
        } catch (\Throwable $exception) {
            response()->json([
                'error' => 'not sent',
                'popup' => 'Ошибка отправки письма',
                'message' => 'Ошибка почтового сервера. Новый пароль не отправлен. 
                    Попробуйте через несколько минут',
            ]);
        }

    }


    public function actionRegister(RegisterRequest $request): void
    {
        $request = $request->safe()->only('email', 'password', 'phone');
        if (!empty($this->userRepository->getByEmail($request['email']))) {
            response()->json(['error' => 'mail exists',
                'message' => 'Такая почта уже существует',
                'popup' => 'Такая почта уже зарегистрирована. Либо войдите под своим паролем. Либо восстановите его.' . "\n"
            ]);
        }

        $user = $this->userRepository->createUser($request);
        if (!$user) response()->json(['error' => 'no user', 'popup' => "Пользователь не создан"]);
        try {
            $this->mailer->sendRegistrationMail($user);
            response()->json(['success' => true, 'popup' => 'Письмо с регистрацией отпрвлено на указанный Вами email']);
        } catch (Throwable $exception) {
            response()->json(['error' => true, 'popup' => 'Письмо не отправлено'], 201);
        }
    }


    #[NoReturn]
    public function actionProfile(): void
    {
        $user = AuthService::getUser();
        if (!$user) {
            response()->redirect('/');
        }

        if ($user->isAdmin() || $user->isEmployee()) {
            $catItem = UserView::employee($user);
        } else {
            $catItem = UserView::guest($user);
        }
        view('profile.profile', compact('catItem'));
    }

    public function actionChangePassword(ChangePasswordRequest $request): void
    {
        if (!isset($request->all()['old_password'])) {
            $user = AuthService::getUser();
            view('auth.change-password', compact('user'));
        }

        $request = $request->validated();

        if (!$request['old_password'] || !$request['new_password'])
            response()->json(['error' => 'Заполните старый и новый пароль']);

        $old_password = PasswordGeneratorService::hashPassword($request['old_password']);
        $user         = $this->userRepository->getByPass($old_password);

        if (!$user) response()->json(['error' => 'Не правильный старый пароль (']);

        $newPassword = PasswordGeneratorService::hashPassword($request['new_password']);

        User::where('id', $user['id'])->update(['password' => $newPassword])
            ? response()->json(['success' => 'Пароль поменян'])
            : response()->json(['msg' => 'Что-то пошло не так (']);


    }

    #[NoReturn]
    public function actionLogout(): void
    {
        AuthService::logout();
        response()->back();
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
