<?php

namespace app\Services\Chat;


class WebsocketHandler extends WebsocketWorker
{
    protected function onOpen($client, $info) {//вызывается при соединении с новым клиентом

    }

    protected function onClose($client) {//вызывается при закрытии соединения клиентом

    }

    protected function onMessage($client, $data) {//вызывается при получении сообщения от клиента
        $data = $this->decode($data);

        if (!$data['payload']) {
            return;
        }

        if (!mb_check_encoding($data['payload'], 'utf-8')) {
            return;
        }
        //var_export($data);
        //шлем всем сообщение, о том, что пишет один из клиентов
        $message = 'пользователь #' . intval($client) . ' (' . $this->pid . '): ' . strip_tags($data['payload']);
        $this->send($message);

        $this->sendHelper($message);
    }

    protected function onSend($data) {//вызывается при получении сообщения от мастера
        $this->sendHelper($data);
    }

    protected function send($message) {//отправляем сообщение на мастер, чтобы он разослал его на все воркеры
        @fwrite($this->master, $message);
    }

    private function sendHelper($data) {
        $data = $this->encode($data);

        $write = $this->clients;
        if (stream_select($read, $write, $except, 0)) {
            foreach ($write as $client) {
                @fwrite($client, $data);
            }
        }
    }
}