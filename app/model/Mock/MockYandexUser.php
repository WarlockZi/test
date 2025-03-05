<?php

namespace app\model\Mock;

use app\model\UserYandex;

class MockYandexUser
{
    public function __construct(
        public UserYandex $user = new UserYandex()
    )
    {
        $this->user->id = 2;
        $this->user->ya_id = '61362802';
        $this->user->login = 'vvoronik';
        $this->user->client_id = '1cacd478c22b49c1a22e59ac811d0fc0';
        $this->user->display_name = 'vvoronik';
        $this->user->real_name = 'Виталий Вороник';
        $this->user->first_name = 'Виталий';
        $this->user->last_name = 'Вороник';
        $this->user->sex = 'male';
        $this->user->default_email = 'vvoronik@yandex.ru';
        $this->user->emails = ["vvoronik@yandex.ru"];
        $this->user->birthday = '1979-11-04';
        $this->user->default_avatar_id = '40138/KIe4rRcAbgP60VIJYhejH12IiUU-1';
        $this->user->is_avatar_empty = '0';
        $this->user->default_phone = '{"id":98618663,"number":"+79217152464"}';
        $this->user->psuid = '1.AAYe6A.Svla6WyDVvSNxLErNUMByg.FTSTsq_qVxLNl5ZwBNeMRg';
        $this->user->rights = 'role_admin';
    }
    public function get():UserYandex
    {
        return $this->user;

    }

}