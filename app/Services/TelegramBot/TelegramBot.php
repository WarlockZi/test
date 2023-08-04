<?php


namespace app\Services\TelegramBot;


class TelegramBot
{

	public function __construct()
	{
		define('TELEGRAM_TOKEN', '6674932414:AAGyg42Rntkd-MqGJWQS6sA-mUMyMMTXA4w');
		define('TELEGRAM_CHATID', '315610444');
	}


	public function send($text)
	{
		$ch = curl_init();
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_POSTFIELDS => array(
					'chat_id' => TELEGRAM_CHATID,
					'text' => $text,
				),
			)
		);
		curl_exec($ch);
	}

}