<?php

namespace app\core\Mail;

use app\core\FS;
use app\model\User;
use app\view\Mail\MailView;
use Throwable;

class PHPMail extends Mail
{
    public function __construct(string $variant)
    {
        parent::__construct($variant);
    }

    public function sendRegistrationMail($user): void
    {
        $this->mailer->setFrom($this->credits['from'], 'VITEX');
        $this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
        $this->mailer->addAddress($user['email']);

        $this->mailer->Subject = 'Регистрация VITEX';

        $this->mailer->isHTML(true);
        $this->mailer->Body    = MailView::registration($user);
        $this->mailer->AltBody = MailView::registrationAlt($user);

        $this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

        $this->mailer->send();
    }

    public function sendNewPasswordMail(User $user, string $newPass): void
    {
        $this->mailer->setFrom($this->credits['from'], 'VITEX');
        $this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
        $this->mailer->addAddress($user['email']);

        $this->mailer->Subject = 'VITEX|новый пароль';

        $this->mailer->isHTML(true);
        $this->mailer->Body = "Ваш новый пароль: " . $newPass;;
        $this->mailer->AltBody = "Ваш новый пароль: " . $newPass;;

        $this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

            $this->mailer->send();
    }

    public function sendTestResults($post, $resid): void
    {
        $this->mailer->setFrom($this->credits['from'], 'VITEX');
        $this->mailer->addReplyTo($this->credits['replyTo'], 'Vitex');
        $this->mailer->addAddress($_ENV['TEST_EMAIL_ALL']);
        $this->mailer->Subject = "{$post['user']}:{$post['errorCnt']} ош из {$post['questionCnt']}";
        $this->mailer->isHTML(true);
        $this->mailer->Body = self::prepareBodyTestResults($post, $resid - 1);

        $this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email=vvoronik@yandex.ru>");
//        $data['to'] = self::getMailsToSendIfRightResults($data['to'], $post['errorCnt']);
//        $data['altBody'] = "Ссылка на страницу с результатами: тут";
        $this->mailer->send();
    }

    private static function prepareBodyTestResults($data, $id): string
    {
        $results_link = "http://" . $_SERVER['HTTP_HOST'] . '/adminsc/testresult/result/' . $id;
        $template     = FS::getFileContent(ROOT . '/app/view/TestResult/do_email.php', compact('data'));
        return $template;
    }
}
