<?php

namespace app\Services\YandexAuth;

use app\core\Auth;
use app\model\Mock\MockYandexUser;
use app\model\UserYandex;
use Throwable;

class YaAuthService
{
    private array $info = [];

    public function __construct()
    {
        if (DEV) {
            $this->setMockYandexUser();
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
        if (!empty($_GET['code'])) {
            // Отправляем код для получения токена (POST-запрос).
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $_GET['code'],
                'client_id' => '1cacd478c22b49c1a22e59ac811d0fc0',
                'client_secret' => '9f08fc34758a4fa3bbc4023e574853ae',
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
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $info = curl_exec($ch);
                curl_close($ch);

                $this->info = json_decode($info, true);

            }
        }
    }

    private function setMockYandexUser(): void
    {
            $this->info = (new MockYandexUser())->get()->attributesToArray();
    }

    private function login(): void
    {
        $userYandex = UserYandex::updateOrCreate(
            ['ya_id' => $this->info['id']],
            [
                'ya_id' => $this->info['id'],
                'login' => $this->info['login'],
                'client_id' => $this->info['client_id'],
                'display_name' => $this->info['display_name'],
                'real_name' => $this->info['real_name'],
                'first_name' => $this->info['first_name'],
                'last_name' => $this->info['last_name'],
                'sex' => $this->info['sex'],
                'default_email' => $this->info['default_email'],
                'emails' => implode(',',$this->info['emails']),
                'birthday' => $this->info['birthday'],
                'default_avatar_id' => $this->info['default_avatar_id'],
                'is_avatar_empty' => $this->info['is_avatar_empty'],
                'default_phone' => $this->info['default_phone'],
                'psuid' => $this->info['psuid'],
                'rights' => implode(',',[]),
            ]
        );

        Auth::setAuth($userYandex);
        Auth::setUser($userYandex);
    }

    public function userData()
    {
        return $this->info;
    }

}