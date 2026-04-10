<?php

namespace app\service\Mail;

use PHPMailer\PHPMailer\PHPMailer;

class ConfiguredPHPMailer
{
    public static function getConfigured(): PHPMailer
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
        return self::setFromSiteCredits($mailer);
    }

    private static function setFromSiteCredits(PHPMailer $mailer): PHPMailer
    {
        $SU_email = env('SU_EMAIL');

        $mailer->setFrom(env('SMTP_FROM_EMAIL'), env('SMTP_FROM_NAME'));
        $mailer->addReplyTo(env('SMTP_REPLY_TO'), env('SMTP_FROM_NAME'));
        $mailer->addAddress($SU_email);

        $mailer->isHTML();
        $mailer->addCustomHeader("List-Unsubscribe", "<mailto:$SU_email?subject=unsubscribe&email=$SU_email>");
        return $mailer;
    }

}