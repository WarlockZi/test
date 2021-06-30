<?php

namespace app\model;

use app\core\App;
use  \PHPMailer\PHPMailer\PHPMailer;

class Mail
{

	public static function send_mail( $subj, $body, $to=[])
	{
		$mail = new PHPMailer(true);
		$config = require ROOT . '/app/core/config.php';
		if ($_SERVER['SERVER_NAME'] == 'vitexopt.ru') {
			$config = $config['Mailer_vitex'];
		} else {
			$config = $config['Mailer'];
		}
		try {
//			$mail->SMTPDebug = 2;  // Enable verbose debug output
			if ($config['smtp_mode']) {
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->SMTPAuth = $config['auth'];                               // Enable SMTP authentication
				$mail->Port = $config['smtp_port'];
				$mail->Username = $config['smtp_username'];                 // SMTP username
				$mail->Password = $config['smtp_pass'];                           // SMTP password
				$mail->SMTPSecure = $config['smtp_SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
			};
			$mail->Host = $config['smtp_host'];  // Specify main and backup SMTP servers
			//Recipients
			$mail->setFrom('vvoronik@yandex.ru', 'vitexopt@vitexopt.ru');

			foreach ($to as $address) {
				$mail->addAddress($address);     // Add a recipient
			}

			$mail->isHTML(true);      // Set email format to HTML
			$mail->Subject = App::$app->mail->toBase64($subj);
			$mail->Body = $body;
			$mail->AltBody = "Ссылка на страницу с результатами: тут";

			$mail->send();
			return true;
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	protected function toBase64($str)
	{
		return "=?utf-8?b?" . base64_encode($str) . "?=";
	}

	protected static function prepareBodyTestResults($file, $userName, $test_name, $questionCnt, $errorCnt)
	{
		$results_link = "http://" . $_SERVER['HTTP_HOST'] . '/test/results/' . $file;
		ob_start();
		require ROOT . '/app/view/Test/email.php';
		$template = ob_get_clean();
		return $template;
	}

	public static function prepareBodyRegister($hash)
	{
		ob_start();
		require ROOT . '/app/view/User/email.php';
		$template = ob_get_clean();
		return $template;
	}

	private function getSubject($errorCnt, $questCnt)
	{
		$errorSubj = $errorCnt == 0 ? 'СДАН' : "не сдан: $errorCnt ош из $questCnt";
		return "=?utf-8?b?" . base64_encode($errorSubj) . "?=";
	}

	private function getBodyTest($file, $userName, $testName, $questCnt, $errorCnt)
	{
		return Mail::testResults();
	}

	public function mail_test_result($subject, $body, $to = [])
	{
		$mail = new PHPMailer(TRUE);
		$config = require ROOT . '/app/core/config.php';
		$config = $config['Mailer'];

		try {
			$mail->SMTPDebug = 2;  // Enable verbose debug output
			if ($config['smtp_mode']) {
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->SMTPAuth = $config['auth'];                               // Enable SMTP authentication
				$mail->Port = $config['smtp_port'];
				$mail->Username = $config['smtp_username'];                 // SMTP username
				$mail->Password = $config['smtp_pass'];                           // SMTP password
				$mail->SMTPSecure = $config['smtp_SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
			};
			$mail->Host = $config['smtp_host'];  // Specify main and backup SMTP servers
			//Recipients
			$mail->setFrom('vvoronik@yandex.ru', $userName);
			foreach ($to as $address) {
				$mail->addAddress('vvoronik@yandex.ru', 'vvv');     // Add a recipient
			}

			//Content
			$mail->isHTML(true); // Set email format to HTML

			$mail->Subject = $this->getSubject($errorCnt, $questCnt);

			$mail->Body = $this->getBodyTest($file, $userName, $testName, $questCnt, $errorCnt);

			$mail->AltBody = "Название теста: $testName/r/n"
				. "От кого: $userName/r/n
				Результат: $errorCnt ошибок из $questCnt
            Ссылка на страницу с результатами: тут";

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}

	}

}
