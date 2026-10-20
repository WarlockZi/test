<?php

namespace app\service\YandexAuth;

use app\model\UserYandex;
use app\service\AuthService\AuthService;

class YaAuthService
{
    private array $user = [];

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
                'emails' => implode(',', $this->user['emails']) ?? null,
                'birthday' => $this->user['birthday']?? null,
                'default_avatar_id' => $this->user['default_avatar_id']?? null,
                'is_avatar_empty' => $this->user['is_avatar_empty']?? null,
                'default_phone' => $this->user['default_phone']?? null,
                'psuid' => $this->user['psuid']?? null,
                'rights' => implode(',', [])?? null,
            ]
        );

        AuthService::login($userYandex);
        AuthService::setUser($userYandex);
    }
}