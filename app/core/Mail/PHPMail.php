<?php

namespace app\core\Mail;

use app\core\FS;
use app\model\User;
use app\view\Mail\MailView;
use PHPMailer\PHPMailer\PHPMailer;
use Throwable;


class PHPMail
{
    protected PHPMailer $mailer;

    public function __construct()
    {
        $this->setMailer();
    }

    protected function setMailer(): void
    {
        $mailer = new PHPMailer();

        $mailer->CharSet = 'UTF-8';
        $mailer->isSMTP();
//        $mailer->SMTPDebug = 1;

        $mailer->Port       = env('SMTP_PORT');
        $mailer->SMTPAuth   = true;
        $mailer->SMTPSecure = 'ssl';

        $mailer->Host     = env('SMTP_HOST');
        $mailer->Username = env('SMTP_USERNAME');
        if (DEV) {
            $mailer->Password = env('YANDEX_APP_KEY_DEV');
        } else {
            $mailer->Password = env('YANDEX_APP_KEY1');
        }

        $mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $this->mailer        = $mailer;
    }

    public function sendRegistrationMail($user): void
    {
            $this->mailer->setFrom(env('SMTP_FROM_EMAIL'), env('SMTP_FROM_NAME'));
            $this->mailer->addReplyTo(env('SMTP_REPLY_TO'), env('SMTP_FROM_NAME'));
            $this->mailer->addAddress($user['email']);

            $this->mailer->Subject = 'VITEX|регистрация';

            $this->mailer->isHTML(true);
            $this->mailer->Body    = MailView::registration($user);
            $this->mailer->AltBody = MailView::registrationAlt($user);

            $this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

            $this->mailer->send();
    }

    public function sendNewPasswordMail(User $user, string $newPass): bool
    {
        $this->mailer->setFrom(env('SMTP_FROM_EMAIL'), env('SMTP_FROM_NAME'));
        $this->mailer->addReplyTo(env('SMTP_REPLY_TO'), env('SMTP_FROM_NAME'));
        $this->mailer->addAddress($user['email']);

        $this->mailer->Subject = 'VITEX|новый пароль';

        $this->mailer->isHTML(true);
        $this->mailer->Body = "Ваш новый пароль: " . $newPass;;
        $this->mailer->AltBody = "Ваш новый пароль: " . $newPass;;

        $this->mailer->addCustomHeader("List-Unsubscribe", "<mailto:vvoronik@yandex.ru?subject=unsubscribe&email={$user['email']}>");

        try {
            $this->mailer->send();
            return true;
        } catch (Throwable $exception) {
            $exc = $exception;
            return false;
        }

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
