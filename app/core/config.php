<?php

$config['components'] = [
	'answer' => 'app\model\Answer',
	'adminsc' => 'app\model\Adminsc',
	'cache' => 'app\core\Cache',
	'category' => 'app\model\Category',
	'freetest' => 'app\model\Freetest',
	'image' => 'app\model\Image',
	'prop' => 'app\model\Prop',
	'product' => 'app\model\Product',
	'main' => 'app\model\Main',
	'mail' => 'app\model\Mail',
	'question' => 'app\model\Question',
	'right' => 'app\model\Right',
	'test' => 'app\model\Test',
	'testresult' => 'app\model\TestResult',
	'user' => 'app\model\User',
	'planning' => 'app\model\Planning',
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
