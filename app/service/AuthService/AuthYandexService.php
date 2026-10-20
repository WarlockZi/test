<?php

namespace app\service\AuthService;

use app\action\AuthYandexActions;
use Psr\Log\NullLogger;
use Tigusigalpa\YandexID\YandexIdClient;

class AuthYandexService
{
    public function __construct()
    {
    }
    public function exchangeCode(): array
    {
        [$clientId, $clientSecret, $redirectUri] = $this->getYandexOptions();

        $client = new YandexIdClient($clientId, $clientSecret, $redirectUri);
        $tokenResponse  = $client->exchangeCode($_GET['code']);

        return $client->getUserInfo($tokenResponse->accessToken)->raw;
        // 🔄 Обновление токена
        //        $newToken = $client->refreshToken($token->refreshToken);
        // 🗑️ Отзыв токена
        //        $success = $client->revokeToken($token->accessToken);
        //        echo "Token revoked: " . ($success ? 'Yes' : 'No') . "\n";
    }
    public function checkYandexResponseState(): void
    {
        $returnedState = $_GET['state'] ?? '';
        $savedState    = $_SESSION['csrf_token'] ?? '';

        if (empty($returnedState) || !hash_equals($savedState, $returnedState)) {
            response()->popup('Invalid OAuth state. Возможна CSRF атака.', 403);
        }
    }
    public function getYandexCode(): void
    {
        [$clientId, $clientSecret, $redirectUri] = $this->getYandexOptions();

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

            $authUrl = $client->authUrl($_SESSION['csrf_token']);
            header('Location: ' . $authUrl);
            exit;
        }
    }
    public function getYandexOptions(): array
    {
        return [env('YANDEX_CLIENTID_DEV'), env('YANDEX_CLIENT_SECRET_DEV'), env('YANDEX_REDIRECT_URI_DEV')];
    }

}

