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
	'mail' => 'app\model\Mail',
	'testresult' => 'app\model\TestResult'
	//'instructions' => 'app\model\Instructions',
];
$config['Mailer_openserver'] = [
	'smtp_host' => "ssl://smtp.gmail.com",
	'auth' => true,
	'smtp_port' => 465,
	'smtp_username' => "vvv35353535",
	'smtp_pass' => "LoopLoop35",
];

$config['Mailer'] = [
//	'smtp_pass' => "tExtile2002",
	'smtp_pass' => "2021(Li)ya",
	'smtp_host' => "ssl://smtp.yandex.ru",
	'from_name' => 'Виталий Викторович', // from (от) имя
	'from_email' => 'vvoronik@yandex.ru', // from (от) email адрес
];

return $config;
