<?php

namespace app\model;

use app\core\App;
use  \PHPMailer\PHPMailer\PHPMailer;

class Mail
{

	protected static function setMailer(){
		$mail = new PHPMailer(true);
//		$mail->SMTPDebug = true;
		$mail->isSMTP();//$mail->SMTP_MODE = (bool)$_ENV['SMTP_MODE'];// Set mailer to use SMTP
		$mail->SMTPAuth = (bool)$_ENV['SMTP_AUTH'];// Enable SMTP authentication
		$mail->Port = (int)$_ENV['SMTP_PORT'];
		$mail->Username = $_ENV['SMTP_USERNAME'];// SMTP username
		$mail->Password = $_ENV['SMTP_PASS'];    // SMTP password
		$mail->SMTPSecure = (bool)$_ENV['SMTP_SMTPSECURE'];// Enable TLS encryption, `ssl` also accepted
		$mail->Host = $_ENV['SMTP_HOST'];  // Specify main and backup SMTP servers
		$mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
		return $mail;
	}

	public static function send_mail($subj, $body, $to = [])
	{
		$mail = self::setMailer();

		try {
			foreach ($to as $address) {
				$mail->addAddress($address);     // Add a recipient
				$mail->addCustomHeader("List-Unsubscribe",
					"<mailto:vvoronik@yandex.ru?subject=unsubscribe>");
			}

			$mail->isHTML(true);// Set email format to HTML
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
