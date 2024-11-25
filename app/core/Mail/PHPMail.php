<?php

namespace app\core\Mail;

use app\model\User;
use app\view\Mail\MailView;

class PHPMail extends Mail
{
	public function __construct(string $variant)
	{
		parent::__construct($variant);
	}

	public function sendRegistrationMail($user): string
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

	public function sendNewPasswordMail(User $user, string $newPass): string
    {
		$this->mailer->setFrom($this->credits['from'], 'VITEX');
		$this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
		$this->mailer->addAddress($user['email']);

		$this->mailer->Subject = 'VITEX|новый пароль';

		$this->mailer->isHTML(true);
		$this->mailer->Body = "Ваш новый пароль: " . $newPass;;
		$this->mailer->AltBody = "Ваш новый пароль: " . $newPass;;

		$this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

        return $this->mailer->send();
//		if () {
//			return 'Письмо для подтверждения email отправлено';
//		}
//		return 'Письмо для подтверждения email не отправлено';
	}


}
