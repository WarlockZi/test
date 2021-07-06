<?php

$config['components'] = [
	'cache' => 'app\core\Cache',
	'main' => 'app\model\Main',
	'prop' => 'app\model\Prop',
	'user' => 'app\model\User',
	'test' => 'app\model\Test',
	'freetest' => 'app\model\Freetest',
	'product' => 'app\model\Product',
	'category' => 'app\model\Category',
	'adminsc' => 'app\model\Adminsc',
	'question' => 'app\model\Question',
	'answer' => 'app\model\Answer',
	'image' => 'app\model\Image',
	'mail'=>'app\model\Mail'
	//'instructions' => 'app\model\Instructions',
];
$config['Mailer_openserver'] = [
	'smtp_host' => "ssl://smtp.gmail.com",
	'smtp_SMTPSecure' => "ssl",
	'auth' => true,
	'smtp_port' => 465,

	 'smtp_username' => "vvv35353535",
    'smtp_pass' => "LoopLoop35",
    'from_name' => 'Виталий Викторович', // from (от) имя
    'from_email' => 'vvv35353535@gail.com', // from (от) email адрес
    'smtp_mode' => 'enabled', // enabled or disabled (включен или выключен)
];

$config['Mailer'] = [
	'smtp_mode' => true, // enabled or disabled (включен или выключен)
	'auth' => true,
	'smtp_port' => 465,
	'smtp_username' => "vvoronik",
//	'smtp_pass' => "tExtile2002",
	'smtp_pass' => "2021(Li)ya",
	'smtp_SMTPSecure' => "ssl",
	'smtp_host' => "ssl://smtp.yandex.ru",
	'from_name' => 'Виталий Викторович', // from (от) имя
	'from_email' => 'vvoronik@yandex.ru', // from (от) email адрес

];

return $config;
