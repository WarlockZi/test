<?php

namespace app\core\Mail;

use app\view\Mail\MailView;

class PHPMail extends Mail
{
	public function __construct(string $variant)
	{
		parent::__construct($variant);
	}

	public function sendRegistrationMail($user)
	{
		$this->mailer->setFrom($this->credits['from'], 'VITEX');
		$this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
		$this->mailer->addAddress($user['email']);

		$this->mailer->Subject = 'Регистрация VITEX';

		$this->mailer->isHTML(true);
		$this->mailer->Body = MailView::registration($user);
		$this->mailer->AltBody = MailView::registrationAlt($user);

		$this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

		if ($this->mailer->send()) {
			return 'Письмо для подтверждения email отправлено';
		}
		return 'Письмо для подтверждения email не отправлено';
	}

	public function returnPassword($user)
	{
		$data['body'] = "Ваш новый пароль: " . $password;

		$this->mailer->setFrom($this->credits['from'], 'VITEX');
		$this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
		$this->mailer->addAddress($user['email']);

		$this->mailer->Subject = 'VITEX|новый пароль';

		$this->mailer->isHTML(true);
		$this->mailer->Body = MailView::returnPass($user);
		$this->mailer->AltBody = MailView::returnPassAlt($user);

		$this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

		if ($this->mailer->send()) {
			return 'Письмо для подтверждения email отправлено';
		}
		return 'Письмо для подтверждения email не отправлено';
	}


}
