<?php


namespace app\core\Mail;


use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class SymfonyMailer extends Mail
{

	public function __construct(string $variant)
	{
		parent::__construct($variant);

		$d = $this->credits;
		$dsn = "smtp://{$d['u']}:{$d['p']}@{$d['h']}:{$d['port']}";
//		$dsn = "smtp://vvoronik:hooliGan35@smtp.yandex.com:465";
		$transport = Transport::fromDsn($dsn);
		$mailer = new Mailer($transport);
		$email = (new Email());
		$email->from($d['m']);
		$email->to($d['t']);
		$email->subject('Demo message using the Symfony Mailer library.');
		$email->text('This is the plain text body of the message.\nThanks,\nAdmin');
		$email->html('This is the HTML version of the message.<br>Example of inline image:<br><img src="cid:nature" width="200" height="200"><br>Thanks,<br>Admin');
//		$email->attachFromPath('/path/to/example.txt');
//		$email->embed(fopen('/path/to/mailor.jpg', 'r'), 'nature');
		$mailer->send($email);
	}

	public function send(){

	}




}