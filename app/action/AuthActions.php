<?php

namespace app\action;

use app\model\User;
use app\service\PasswordGenerator\PasswordGeneratorService;
use Psr\Log\NullLogger;
use Tigusigalpa\YandexID\Exceptions\ApiException;
use Tigusigalpa\YandexID\Exceptions\InvalidRequestException;
use Tigusigalpa\YandexID\YandexIdClient;

class AuthActions
{
    public function checkLoginPasswordConfirm($validated): ?User
    {
        $user = User::where('email', $validated['email'])->with('role')->first();

        if (!$user) response()->json([
            'error' => 'email не найден',
            'popup' => 'Пройдите регистрацию']);

        if (!$user->confirm) response()->json([
            'error' => 'Зайдите на почту чтобы подтвердить регистрацию',
            'popup' => 'Зайдите на почту чтобы подтвердить регистрацию',]);
        if ($user->password !== PasswordGeneratorService::hashPassword($validated['password'])) {
            if (!$user->isSU()) {
                response()->json(['error' => 'Не верный email или пароль']);
            }
        }
        return $user;
    }
    public function checkYandexResponseState(): void
    {
        $returnedState = $_GET['state'] ?? '';
        $savedState    = $_COOKIE['yandex_oauth_state'] ?? '';

        if (empty($returnedState) || !hash_equals($savedState, $returnedState)) {
            response()->popup('Invalid OAuth state. Возможна CSRF атака.', 403);
        }
    }

    /**
     * @throws ApiException
     * @throws InvalidRequestException
     */
    public function exchangeCode(string $clientId, string $clientSecret, string $code): array
    {
        $client = new YandexIdClient($clientId, $clientSecret);
        $token  = $client->exchangeCode($code);

        return $client->getUserInfo($token->accessToken)->raw;
    }

    public function getYandexOptions(): array
    {
        return [env('YANDEX_CLIENTID_DEV'), env('YANDEX_CLIENT_SECRET_DEV'), env('YANDEX_REDIRECT_URI_DEV')];
    }
    public function getYandexCode(string $clientId, string $clientSecret, string $redirectUri): array
    {
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
}