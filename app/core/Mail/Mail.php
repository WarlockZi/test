<?php


namespace app\core\Mail;


use PHPMailer\PHPMailer\PHPMailer;
use function PHPUnit\Framework\isInstanceOf;

class Mail
{
    protected array $credits;
    protected PHPMailer|ConsoleMailer $mailer;
    protected string $variant;

    public function __construct(string $variant)
    {
        $this->variant = $variant;
        $this->credits = $this->setCredits();
        $this->mailer  = ($this->variant === 'console')
            ? new ConsoleMailer()
            : new PHPMailer(true);
        $this->setMailer();
    }

    protected function setCredits(): array
    {
        $variants = [
            'env' => [
                'mail' => env('SMTP_FROM_EMAIL'),
                'host' => env('SMTP_HOST'),
                'port' => env('SMTP_PORT'),
                'user' => env('SMTP_USERNAME'),
                'pass' => env('YANDEX_APP_KEY1'), // пароль для стороннего приложения
                'from' => env('SMTP_FROM_EMAIL'),
                'replyTo' => env('SMTP_FROM_EMAIL'),
            ],
            'yandexnew' => [
                'app_key' => env('YANDEX_APP_KEY'), // пароль для стороннего приложения
            ],

            'vitex' => [
                'mail' => 'vitexopt@vitexopt.ru',
                'host' => 'smtp.vitexopt.ru',
                'port' => '465',
                'user' => "vitexopt@vitexopt.ru",
                'pass' => "KiteKite35",
                'from' => 'vitexopt@vitexopt.ru',
                'replyTo' => 'vvoronik@yandex.ru',
                'to' => 'vitaliy04111979@gmail.com',
            ],
        ];

        return $variants[$this->variant];
    }


    public function setToFromBody(array $props)
    {
        $mailDTO = [
            'To' => array('email', 'name'),
            'From' => 'email',
            'FromName' => 'name',
            'MsgHTML' => 'dd',
            'AltBody' => 'dd',

        ];
        if (!empty($props['to'])) {
            $this->mailer->AddAddress($props['to']['email'], $props['to']['name']);
        }
        $this->mailer->From = $props['From'] ?? "";
        $this->mailer->FromName = $props['FromName'] ?? "";
        $this->mailer->MsgHTML($props['MsgHTML'] ?? "");
        $this->mailer->AltBody = $props['AltBody']??"";
    }


    protected function setMailer(): void
    {
        if (!isInstanceOf(PHPMailer::class)) return;
        $credits               = $this->credits;
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 1;

        $this->mailer->Port       = $credits['port'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->SMTPSecure = 'ssl';

        $this->mailer->Host     = $credits['host'];
        $this->mailer->Username = $credits['user'];
        $this->mailer->Password = $credits['pass'];

        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    public static function toBase64($str)
    {
        return "=?utf-8?b?" . base64_encode($str) . "?=";
    }

    public function send(): void
    {
        try {
            $this->mailer->send();
            echo 'Message sent';
        } catch (\Throwable $e) {
            echo 'Mailer Error';
            $this->mailer->getSMTPInstance()->reset();
        }
        $this->mailer->clearAddresses();
        $this->mailer->clearAttachments();

    }
}
