<?php

namespace app\Services\YandexAuth;

class YaAuthService
{
public function __construct()
{
    print_r($_GET);
    print_r($_POST);

    $state = $_GET['state']; // 123

    if (!empty($_GET['code'])) {
        // Отправляем код для получения токена (POST-запрос).
        $params = array(
            'grant_type'    => 'authorization_code',
            'code'          => $_GET['code'],
            'client_id'     => '1cacd478c22b49c1a22e59ac811d0fc0',
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

            $info = json_decode($info, true);
            print_r($info);
        }
    }
}

}