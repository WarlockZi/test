<?php

namespace app\controller;

use app\action\AuthActions;
use app\formRequest\ChangePasswordRequest;
use app\formRequest\LoginRequest;
use app\formRequest\RegisterRequest;
use app\formRequest\ReturnPassRequest;
use app\model\User;
use app\repository\UserRepository;
use app\service\AuthService\Auth;
use app\service\Mail\PHPMailService;
use app\service\PasswordGenerator\PasswordGeneratorService;
use app\service\Router\IRequest;
use app\view\User\UserView;
use Exception;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\NullLogger;
use Throwable;
use Tigusigalpa\YandexID\Exceptions\ApiException;
use Tigusigalpa\YandexID\Exceptions\InvalidRequestException;
use Tigusigalpa\YandexID\YandexIdClient;

class AuthController extends AppController
{
    public function __construct(
        protected AuthActions $actions,
        protected PHPMailService $mailer,
        protected UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @throws ValidationException|Exception
     */
    #[NoReturn]
    public function actionLogin(LoginRequest $request): void
    {
        $validated = $request->safe()->only('email', 'password');

        $user = User::where('email', $validated['email'])->with('role')->first();

        if (!$user) response()->json([
            'error' => 'email не зарегистрирован',
            'popup' => 'Пройдите регистрацию']);

        if (!$user->confirm) response()->json([
            'error' => 'Зайдите на почту чтобы подтвердить регистрацию',
            'popup' => 'Зайдите на почту чтобы подтвердить регистрацию',]);
        if ($user->password !== PasswordGeneratorService::hashPassword($validated['password'])) {
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
            response()->json(['role' => 'admin', 'id' => $user['id']]);
        } else {
            response()->json(['role' => 'guest', 'id' => $user['id']]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function actionReturnpass(ReturnPassRequest $request): void
    {
        $req = $request->validated();

        session()->forget('id');
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

    /**
     * @throws ValidationException
     */
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

    /**
     * @throws ApiException
     * @throws InvalidRequestException
     */
    public function actionYandex(): void
    {
        $clientId     = env('YANDEX_CLIENTID_DEV');
        $clientSecret = env('YANDEX_CLIENT_SECRET_DEV');
        $redirectUri  = env('YANDEX_REDIRECT_URI_DEV');
        if (!isset($_GET['code'])) {
            $client = new YandexIdClient(
                clientId: $clientId,
                clientSecret: $clientSecret,
                redirectUri: $redirectUri,
                scope: 'login:email login:info',
                forceConfirm: false,
                authBase: 'https://oauth.yandex.ru',
                userInfoEndpoint: 'https://login.yandex.ru/info',
                userInfoAuth: 'OAuth',
                http: null, // Используем Guzzle по умолчанию
                logger: new NullLogger() // или ваш PSR-3 логгер
            );

            $authUrl = $client->authUrl($_SESSION['phpSession'] ?? 'random_state_123');
            header('Location: ' . $authUrl);
            exit;
        }

        $code = $this->actions->checkYandexResponseState();

        $yandexProfile = $this->actions->exchangeCode($clientId, $clientSecret,$code);
        $user = (new UserRepository)->getByEmail($yandexProfile['default_email'], ['*'], ['role'] );


        Auth::setAuth($user);
        response()->redirect('/');

// 🔄 Обновление токена
//        $newToken = $client->refreshToken($token->refreshToken);

// 🗑️ Отзыв токена
//        $success = $client->revokeToken($token->accessToken);
//        echo "Token revoked: " . ($success ? 'Yes' : 'No') . "\n";
    }


    #[NoReturn]
    public function actionProfile(): void
    {
        $user = Auth::getUser();
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
        if (!Auth::getUser()) {
            response()->withError('чтобы поменять пароль нужно войти в свой аккаунт')->redirect('/');
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

        view('auth.change-password', compact('user'));


    }

    #[NoReturn]
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
