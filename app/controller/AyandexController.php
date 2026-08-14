<?php

namespace app\controller;
use Tigusigalpa\YandexID\YandexIdClient;
use Tigusigalpa\YandexID\Dto\TokenResponse;
use Tigusigalpa\YandexID\Dto\UserInfo;
use Psr\Log\NullLogger;

class AyandexController extends AppController
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $clientId     = env('YANDEX_CLIENTID_DEV');
        $clientSecret = env('YANDEX_CLIENT_SECRET_DEV');
        $redirectUri  = env('YANDEX_REDIRECT_URI_DEV');
        $client       = new YandexIdClient(
            clientId: $clientId,
            clientSecret: $clientSecret,
            redirectUri: $redirectUri,
            scope: 'login:email login:info',
            forceConfirm: false,
            authBase: 'https://oauth.yandex.ru',
            userInfoEndpoint: 'https://login.yandex.ru/info',
            userInfoAuth: 'OAuth',
//            httpClient: null, // Используем Guzzle по умолчанию
            logger: new NullLogger() // или ваш PSR-3 логгер
        );
        $authUrl      = $client->authUrl('random_state_123');
        header('Location: ' . $authUrl);
        exit;
    }
}