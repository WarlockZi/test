<?php


namespace app\Services\TelegramBot;


class TelegramBot
{
    private string $TELEGRAM_VitexTestBot_TOKEN;
    private string $TELEGRAM_VITEX_SALES_CHANNAL_ID;

    public function __construct()
    {
        $this->TELEGRAM_VitexTestBot_TOKEN     = $_ENV['TELEGRAM_VitexTestBot_TOKEN'];
        $this->TELEGRAM_CHAT_ID                = $_ENV['TELEGRAM_CHAT_ID'];
        $this->TELEGRAM_VITEX_SALES_CHANNAL_ID = $_ENV['TELEGRAM_VITEX_SALES_CHANNAL_ID'];
    }


    public function send($text)
    {
        $token = $this->TELEGRAM_VitexTestBot_TOKEN;
        $ID = $this->TELEGRAM_VITEX_SALES_CHANNAL_ID;

        $url = "https://api.telegram.org/bot";
        $action = '/sendMessage?';
        $chatId = "chat_id=-100{$ID}&";
        $text = "text=$text";

        $string = "{$url}{$token}{$action}{$chatId}{$text}";

        $resp =file_get_contents($string);
    }
}