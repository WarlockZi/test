<?php

namespace app\service\Mail;

use app\model\User;
use app\service\Fs\FS;
use app\view\Mail\MailView;
use PHPMailer\PHPMailer\PHPMailer;
use Throwable;


class PHPMailService
{
    public function __construct(
        protected PHPMailer $mailer,
    )
    {
        $this->mailer = ConfiguredPHPMailer::getConfigured();
    }

    public function sendRegistrationMail(User $user): void
    {
        $this->mailer->Subject = 'VITEX|регистрация';
        $this->mailer->Body    = MailView::registration($user);
        $this->mailer->AltBody = MailView::registrationAlt($user);
        try {
            $this->mailer->addAddress($user->email);
            $this->mailer->send();
        } catch (Throwable $exception) {
            $exc = $exception;
        }
    }


    public function sendNewPasswordMail(User $user, string $newPass): bool
    {
        $this->mailer->Subject = 'VITEX|новый пароль';
        $this->mailer->Body    = "Ваш новый пароль: " . $newPass;;
        $this->mailer->AltBody = "Ваш новый пароль: " . $newPass;;

        try {
            $this->mailer->addAddress($user->email);
            $this->mailer->send();
            return true;
        } catch (Throwable $exception) {
            $exc = $exception;
            return false;
        }
    }

    public function sendTestResults($post, $resid): void
    {
        $this->mailer->Subject = "{$post['user']}:{$post['errorCnt']} ош из {$post['questionCnt']}";

        $results_link       = "http://" . $_SERVER['HTTP_HOST'] . '/adminsc/testresult/result/' . $resid - 1;
        $template           = FS::getFileContent(ROOT . '/app/view/TestResult/do_email.php', ['data' => $post]);
        $this->mailer->Body = $template;
        $this->mailer->send();
    }

}
