<?php

namespace app\model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
	protected static function setMailer(){
		$mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
		$mail->isSMTP();
		$mail->SMTPAuth = (bool)$_ENV['SMTP_AUTH'];
		$mail->Port = (int)$_ENV['SMTP_PORT'];
		$mail->Username = $_ENV['SMTP_USERNAME'];
		$mail->Password = $_ENV['SMTP_PASS'];
		$mail->SMTPSecure = (bool)$_ENV['SMTP_SMTPSECURE'];
		$mail->Host = $_ENV['SMTP_HOST'];
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
			$mail->addCustomHeader("List-Unsubscribe","<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$address}>");
			$mail->isHTML(true);
			$mail->Subject = $data['subject']??'';
			$mail->Body = $data['body']??'';
			$mail->AltBody = $data['altBody']??'';
			$mail->send();
			return true;
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	public static function toBase64($str)
	{
		return "=?utf-8?b?" . base64_encode($str) . "?=";
	}

}
