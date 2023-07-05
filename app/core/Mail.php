<?php

namespace app\core;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
	protected static function setMailer()
	{
		$mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Port = 465;
		$mail->Username = $_ENV['SMTP_USERNAME'];
		$mail->Password = $_ENV['SMTP_PASS'];
		$mail->SMTPAuth = true;
//		$mail->SMTPSecure = (bool)$_ENV['SMTP_SMTPSECURE'];
		$mail->Host = 'smtp.yandex.ru';

//		$mail->Port = (int)$_ENV['SMTP_PORT'];
//		$mail->Username = $_ENV['SMTP_USERNAME'];
//		$mail->Password = $_ENV['SMTP_PASS'];
//		$mail->SMTPAuth = (bool)$_ENV['SMTP_AUTH'];
//		$mail->SMTPSecure = (bool)$_ENV['SMTP_SMTPSECURE'];
//		$mail->Host = $_ENV['SMTP_HOST'];

//		vitaliy04111979@gmail.com
		$mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
		$mail->CharSet = "utf-8";
		return $mail;
	}

	public static function send_mail($data)
	{
		$mail = self::setMailer();

		try {
			foreach ($data['to'] as $address) {
				$mail->addAddress($address);
			}
//				$mail->addAddress('vvoronik@yandex.ru');
			$mail->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$address}>");
			$mail->isHTML(true);
			$mail->Subject = $data['subject'] ?? '';
			$mail->Body = $data['body'] ?? '';
			$mail->AltBody = $data['altBody'] ?? '';
			$res = $mail->send();
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
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

	private static function getConfirmBody(string $hash, string $href):string
	{
		ob_start();
		require ROOT . '/app/view/Auth/email.php';
		return ob_get_clean();
	}

}
