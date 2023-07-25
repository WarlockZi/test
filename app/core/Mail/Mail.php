<?php


namespace app\core\Mail;


use stdClass;

class Mail
{
	protected $credits;
	protected $mailer;

	public function __construct(string $variant)
	{
		$this->credits = $this->setCredits($variant);
	}

	protected function setCredits(string $variant): array
	{
		$variants = new stdClass();
		$variants->google = [
			'm' => 'vitaliy04111979@gmail.com',
			'h' => 'smtp.gmail.com',
			'port' => '465',
			'u' => 'vitaliy04111979@gmail.com',
			'p' => 'hooliGan35',
			'from'=>'vitaliy04111979@gmail.com',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vvoronik@yandex.ru',
		];
		$variants->yandex = [
			'm' => 'vvoronik@yandex.ru',
			'h' => 'smtp.yandex.com',
			'port' => '465',
			'u' => "vvoronik@yandex.ru",
			'p' => "hooliGan35",
			'from'=>'vvoronik@yandex.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];
		$variants->vitex = [
			'm' => 'vitexopt@vitexopt.ru',
			'h' => 'smtp.vitexopt.ru',
			'port' => '465',
			'u' => "vitexopt@vitexopt.ru",
			'p' => "KiteKite35",
			'from'=>'vitexopt@vitexopt.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];
		$variants->elastic = [
//			'm' => 'vitexopt@vitexopt.ru',
			'h' => 'smtp.elasticemail.com',
			'port' => '2525',
			'u' => "vitaliy04111979@gmail.com",
			'p' => "E934E38F8B061BA7F7DE3040B96B3C511A56",
			'from'=>'vitexopt@vitexopt.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];
		return $variants->$variant;
	}

}
