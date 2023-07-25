<?php

namespace app\core\Mail;

use Exception;
//use PHPMailer\PHPMailer\PHPMailer;
use ElasticEmail\Configuration;

class ElasticMail extends Mail
{
	public function __construct(string $variant)
	{
		parent::__construct($variant);
//		require_once(__DIR__.'../../../vendor/elasticemail/elasticemail-php/autoload.php');


		$config = ElasticEmail\Configuration::getDefaultConfiguration()->setApiKey('X-ElasticEmail-ApiKey', 'E934E38F8B061BA7F7DE3040B96B3C511A56');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = ElasticEmail\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-ElasticEmail-ApiKey', 'Bearer');


		$apiInstance = new ElasticEmail\Api\CampaignsApi(
		// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		// This is optional, `GuzzleHttp\Client` will be used as default.
			new GuzzleHttp\Client(),
			$config
		);
		$name = 'name_example'; // string | Name of Campaign to delete

		try {
			$apiInstance->campaignsByNameDelete($name);
		} catch (Exception $e) {
			echo 'Exception when calling CampaignsApi->campaignsByNameDelete: ', $e->getMessage(), PHP_EOL;
		}
		$this->setMailer();
		$this->setContent();
		$this->setToFrom();
		$this->mailer->send();
	}

	protected function setMailer(): void
	{
		$d = $this->credits;

		$this->mailer = new PHPMailer(true);
		$this->mailer->isSMTP();
		$this->mailer->SMTPDebug = 1;
		$this->mailer->Debugoutput = 'html';

		$this->mailer->Port = 465;
		$this->mailer->SMTPAuth = true;
		$this->mailer->SMTPSecure = 'ssl';
//		$this->setSMTPOptions();

		$this->mailer->Host = $d['h'];
		$this->mailer->Username = $d['u'];       // ваше имя пользователя (без домена и @)
		$this->mailer->Password = $d['p'];    // ваш пароль

	}

	protected function setSMTPOptions()
	{
		$this->mailer->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true)
		);
	}

	protected function setContent()
	{
		$this->mailer->isHTML(true);
		$this->mailer->Subject = 'Тест';
		$this->mailer->msgHTML("<html><body>
                <h1>Здравствуйте!</h1>
                <p>Это тестовое письмо.</p>
                </html></body>");
		$this->mailer->AltBody = 'This is a plain-text message body';
	}

	protected function setToFrom()
	{
		$this->mailer->setFrom($this->credits['from'], 'Тестовый отправитель Timeweb'); # от кого
		$this->mailer->addReplyTo($this->credits['replyTo'], 'First Last'); # адрес для ответа
		$this->mailer->addAddress($this->credits['to'], 'Nikita Kulizhnikov'); # кому
	}

	protected function envSetup()
	{
//		$mail->CharSet = "utf-8";
//		$mail->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$address}>");
		//		$mail->Port = (int)$_ENV['SMTP_PORT'];
//		$mail->Username = $_ENV['SMTP_USERNAME'];
//		$mail->Password = $_ENV['SMTP_PASS'];
//		$mail->SMTPAuth = (bool)$_ENV['SMTP_AUTH'];
//		$mail->SMTPSecure = (bool)$_ENV['SMTP_SMTPSECURE'];
//		$mail->Host = $_ENV['SMTP_HOST'];
//		vitaliy04111979@gmail.com
//		$mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
	}

	public function send($data='')
	{
//		$mailer = self::setMailer();

		try {
//			foreach ($data['to'] as $address) {
//				$mailer->addAddress($address);
//			}
//				$mailer->addAddress('vvoronik@yandex.ru');
//			$mailer->Subject = $data['subject'] ?? '';
//			$mailer->Body = $data['body'] ?? '';
//			$mailer->AltBody = $data['altBody'] ?? '';
			$res = $this->mailer->send();
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
		}
	}

	public static function toBase64($str)
	{
		return "=?utf-8?b?" . base64_encode($str) . "?=";
	}

	public static function mailConfirmFactory(array $user): array
	{
		$data['subject'] = "Регистрация VITEX";
		$data['to'] = [$user['email']];
		$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/auth/confirm/{$user['hash']}";

		$data['body'] = self::getConfirmBody($user['hash'], $href);

		$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>";
		return $data;
	}

	private static function getConfirmBody(string $hash, string $href): string
	{
		ob_start();
		require ROOT . '/app/view/Auth/email.php';
		return ob_get_clean();
	}

}
