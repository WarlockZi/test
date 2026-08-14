<?php

namespace app\action;

use Tigusigalpa\YandexID\Exceptions\ApiException;
use Tigusigalpa\YandexID\Exceptions\InvalidRequestException;
use Tigusigalpa\YandexID\YandexIdClient;

class AuthActions
{

    public function checkYandexResponseState(): string
    {
        $returnedState = $_GET['state'] ?? '';
        $savedState = $_COOKIE['yandex_oauth_state'] ?? '';

        setcookie('yandex_oauth_state', '', time() - 3600, '/');

        if (empty($returnedState) || !hash_equals($savedState, $returnedState)) {
            http_response_code(403);
            die('Invalid OAuth state. Possible CSRF attack.');
        }
            return $_GET['code'] ?? '';
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
}