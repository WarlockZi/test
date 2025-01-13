<?php


namespace app\Services\TelegramBot;


class TelegramBot
{
    private string $TELEGRAM_VitexTestBot_TOKEN;
    private string $chat_id;

    public function __construct(string $channel)
    {
        $this->setChanel($channel);
        $this->TELEGRAM_VitexTestBot_TOKEN     = $_ENV['TELEGRAM_VitexTestBot_TOKEN'];
    }

    private function setChanel($channel): void
    {
        if ($channel===TGChannel::callme->name) {
            $this->chat_id = '-100'.$_ENV['TELEGRAM_VITEX_CALLME_CHANNAL_ID'];

        }elseif ($channel===TGChannel::question->name){
            $this->chat_id = '-100'.$_ENV['TELEGRAM_VITEX_SALES_CHANNAL_ID'];
        }

    }


    public function send($text): void
    {
        $token = $this->TELEGRAM_VitexTestBot_TOKEN;

        $url = "https://api.telegram.org/bot";
        $action = '/sendMessage?';
        $chatId = "chat_id={$this->chat_id}&";
        $text = "text=Перезвоните мне $text";

        $string = "{$url}{$token}{$action}{$chatId}{$text}";

        $resp =file_get_contents($string);
    }
}