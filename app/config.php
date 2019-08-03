<?php

$config['components'] = [
    'cache' => 'app\core\Cache',
    'main' => 'app\model\Main',
    'prop' => 'app\model\Prop',
    'user' => 'app\model\User',
    'test' => 'app\model\Test',
    'freetest' => 'app\model\Freetest',
    'catalog' => 'app\model\Catalog',
    'category' => 'app\model\Category',
    'adminsc' => 'app\model\Adminsc',
   //'instructions' => 'app\model\Instructions',
];

$config['Mailer'] = [
    'smtp_host' => "ssl://smtp.gmail.com",
    'smtp_SMTPSecure' => "ssl",
    'auth' => TRUE,
    'smtp_port' => 465,
    'smtp_username' => "vvv35353535",
    'smtp_pass' => "LoopLoop35",
    'from_name' => 'Виталий Викторович', // from (от) имя
    'from_email' => 'vvv35353535@gail.com', // from (от) email адрес
    'smtp_mode' => 'enabled', // enabled or disabled (включен или выключен)
//        'from_name' => 'Виталий Викторович', // from (от) имя
//        'from_email' => 'vvoronik@yandex.ru', // from (от) email адрес
//        'smtp_mode' => true, // enabled or disabled (включен или выключен)
//        'smtp_host' => "ssl://mail.vitexopt.ru",
//        'smtp_port' => 465,
//        'smtp_username' => "VVV_DIR",
];

if ($_SERVER['HTTP_HOST'] == 'vitexopt.ru') {

   $config['config_db']['dsn'] = 'mysql:host=localhost;dbname=vitex_test;charset=utf8';
   $config['config_db']['user'] = 'vitexopt';
   $config['config_db']['password'] = '8D8p6L2x';
} else {

   $config['config_db']['dsn'] = 'mysql:host=127.0.0.1;dbname=vitex_test;charset=utf8';
   $config['config_db']['user'] = 'root';
   $config['config_db']['password'] = '';
};


return $config;
