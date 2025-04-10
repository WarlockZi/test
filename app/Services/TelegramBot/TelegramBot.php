<?php


namespace app\Services\TelegramBot;


class TelegramBot
{
    private string $TELEGRAM_VITEX_TEST_BOT_TOKEN;
    private string $chat_id;
    private string $text;

    public function __construct(string $channel)
    {
        $this->setChanel($channel);
        $this->setText($channel);
        $this->TELEGRAM_VITEX_TEST_BOT_TOKEN = env('TELEGRAM_VITEX_TEST_BOT_TOKEN');
    }

    private function setChanel($channel): void
    {
        if ($channel === TGChannel::callme->name) {
            $this->chat_id = '-100' . env('TELEGRAM_VITEX_CALLME_CHANNAL_ID');

        } elseif ($channel === TGChannel::question->name) {
            $this->chat_id = '-100' . env('TELEGRAM_VITEX_SALES_CHANNAL_ID');
        }
    }
    private function setText($channel): void
    {
        if ($channel === TGChannel::callme->name) {
            $this->text = "text=Перезвоните мне ";

        } elseif ($channel === TGChannel::question->name) {
            $this->text = "text=Сообщение обратной связи от";
        }
    }

    public function send($text): void
    {
        $token = $this->TELEGRAM_VITEX_TEST_BOT_TOKEN;

        $url    = "https://api.telegram.org/bot";
        $action = '/sendMessage?';
        $chatId = "chat_id={$this->chat_id}&";
        $text   = $this->text. $text;

        $string = "{$url}{$token}{$action}{$chatId}{$text}";

        $resp = file_get_contents($string);
    }
}