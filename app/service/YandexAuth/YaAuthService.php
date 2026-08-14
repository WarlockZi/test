<?php

namespace app\service\YandexAuth;

use app\model\Mock\MockYandexUser;
use app\model\UserYandex;
use app\service\AuthService\Auth;
use Throwable;

class YaAuthService
{
    private array $user = [];

    public function __construct()
    {
        if (DEV) {
            $this->setYandexUser();
//            $this->setMockYandexUser();
        } else {
            $this->setYandexUser();
        }
        try {
            $this->login();
        } catch (Throwable $exception) {
            echo $exception;
        }
    }

    private function setYandexUser(): void
    {
        $clientId=env('YANDEX_CLIENTID_DEV');
        $clientSecret=env('YANDEX_CLIENT_SECRET_DEV');
        if (!empty($_GET['code'])) {
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $_GET['code'],
                'client_id' => $_GET['cid'],
//                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => 'https://vi-prod/auth/yandex',
            );

            $ch = curl_init('https://oauth.yandex.ru/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($data, true);
            if (!empty($data['access_token'])) {
                // Токен получили, получаем данные пользователя.
                $ch = curl_init('https://login.yandex.ru/info');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $data['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $info = curl_exec($ch);
                curl_close($ch);

                $this->user = json_decode($info, true);
            }
        }
    }

    private function setMockYandexUser(): void
    {
        $this->user = (new MockYandexUser())->get()->attributesToArray();
    }

    private function login(): void
    {
        $userYandex = UserYandex::updateOrCreate(
            ['ya_id' => $this->user['id'] ?? null],
            [
                'ya_id' => $this->user['id'] ?? null,
                'login' => $this->user['login'] ?? null,
                'client_id' => $this->user['client_id'] ?? null,
                'display_name' => $this->user['display_name'] ?? null,
                'real_name' => $this->user['real_name'] ?? null,
                'first_name' => $this->user['first_name'] ?? null,
                'last_name' => $this->user['last_name'] ?? null,
                'sex' => $this->user['sex'] ?? null,
                'default_email' => $this->user['default_email'] ?? null,
//                'emails' => implode(',', $this->user['emails']) ?? null,
//                'birthday' => $this->user['birthday'],
//                'default_avatar_id' => $this->user['default_avatar_id'],
//                'is_avatar_empty' => $this->user['is_avatar_empty'],
//                'default_phone' => $this->user['default_phone'],
//                'psuid' => $this->user['psuid'],
//                'rights' => implode(',', []),
            ]
        );

        Auth::setAuth($userYandex);
        Auth::setUser($userYandex);
    }

    public function getUser(): array
    {
        return $this->user;
    }

}