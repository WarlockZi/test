<?php


namespace app\core\Mail;


use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

class Mail
{
	protected $credits;
	protected $mailer;

	public function __construct(string $variant)
	{
		$this->credits = $this->setCredits($variant);
		$this->setMailer();
	}

	public static function toBase64($str)
	{
		return "=?utf-8?b?" . base64_encode($str) . "?=";
	}

	protected function setCredits(string $variant): array
	{
		$variants = new stdClass();

		$variants->env = [
			'mail' 	=> env('SMTP_FROM_EMAIL'),
			'host' 	=> env('SMTP_HOST'),
			'port' 	=> env('SMTP_PORT'),
			'user' 	=> env('SMTP_USERNAME'),
			'pass' 	=> env('YANDEX_APP_KEY'), // пароль для стороннего приложения
			'from'	=>env('SMTP_FROM_EMAIL'),
			'replyTo'=>env('SMTP_FROM_EMAIL'),
		];

		$variants->yandexnew = [
			'mail' => 'vvoronik@yandex.ru',
			'host' => 'smtp.yandex.com',
			'port' => '465',
			'user' => "vvoronik@yandex.ru",
			'pass' => "cvygknpfqqdxxmis", // пароль для стороннего приложения
			'from'=>'vvoronik@yandex.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];

		$variants->yandex = [
			'mail' => 'vvoronik@yandex.ru',
			'host' => 'smtp.yandex.com',
			'port' => '465',
			'user' => "vvoronik@yandex.ru",
			'pass' => "hooliGan35",
			'from'=>'vvoronik@yandex.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];
		$variants->google = [
			'mail' => 'vitaliy04111979@gmail.com',
			'host' => 'smtp.gmail.com',
			'port' => '465',
			'user' => 'vitaliy04111979@gmail.com',
			'pass' => 'hooliGan35',
			'from'=>'vitaliy04111979@gmail.com',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vvoronik@yandex.ru',
		];

		$variants->vitex = [
			'mail' => 'vitexopt@vitexopt.ru',
			'host' => 'smtp.vitexopt.ru',
			'port' => '465',
			'user' => "vitexopt@vitexopt.ru",
			'pass' => "KiteKite35",
			'from'=>'vitexopt@vitexopt.ru',
			'replyTo'=>'vvoronik@yandex.ru',
			'to' => 'vitaliy04111979@gmail.com',
		];

		return $variants->$variant;
	}
	protected function setMailer(): void
	{
		$credits = $this->credits;

		$this->mailer = new PHPMailer(true);
		$this->mailer->CharSet='UTF-8';
		$this->mailer->isSMTP();
//		$this->mailer->SMTPDebug = 1;
//		$this->mailer->Debugoutput = 'html';

		$this->mailer->Port = $credits['port'];
		$this->mailer->SMTPAuth = true;
		$this->mailer->SMTPSecure = 'ssl';

		$this->mailer->Host = $credits['host'];
		$this->mailer->Username = $credits['user'];
		$this->mailer->Password = $credits['pass'];
	}

	public function send(): void
    {
		try {
			$res = $this->mailer->send();
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
		}
	}
}
