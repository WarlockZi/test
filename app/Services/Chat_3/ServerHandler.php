<?php

namespace app\Services\Chat_3;

use Exception;
use WSSC\Contracts\ConnectionContract;
use WSSC\Contracts\WebSocket;
use WSSC\Exceptions\WebSocketException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ServerHandler extends WebSocket
{
    /*
     *  if You need to parse URI context like /messanger/chat/JKN324jn4213
     *  You can do so by placing URI parts into an array - $pathParams, when Socket will receive a connection
     *  this variable will be appropriately set to key => value pairs, ex.: ':context' => 'chat'
     *  Otherwise leave $pathParams as an empty array
     */
    public array $pathParams = [':entity', ':context', ':token'];
    private array $clients = [];

    private Logger $log;

    /**
     * ServerHandler constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->log = new Logger('ServerSocket');
        $this->log->pushHandler(new StreamHandler('./tests/tests.log'));
    }

    public function onOpen(ConnectionContract $conn): void
    {
        $this->clients[$conn->getUniqueSocketId()] = $conn;
        $this->log->debug('Connection opend, total clients: ' . count($this->clients));
    }

    public function onMessage(ConnectionContract $recv, $msg): void
    {
        $this->log->debug('Received message:  ' . $msg);
        $recv->send($msg);
    }

    public function onClose(ConnectionContract $conn): void
    {
        unset($this->clients[$conn->getUniqueSocketId()]);
        $this->log->debug('close: ' . print_r($this->clients, 1));
        $conn->close();
    }

    /**
     * @param ConnectionContract $conn
     * @param WebSocketException $ex
     */
    public function onError(ConnectionContract $conn, WebSocketException $ex): void
    {
        echo 'Error occured: ' . $ex->printStack();
    }

    /**
     * You may want to implement these methods to bring ping/pong events
     *
     * @param ConnectionContract $conn
     * @param string $msg
     */
    public function onPing(ConnectionContract $conn, $msg)
    {
        // TODO: Implement onPing() method.
    }

    /**
     * @param ConnectionContract $conn
     * @param $msg
     * @return mixed
     */
    public function onPong(ConnectionContract $conn, $msg)
    {
        // TODO: Implement onPong() method.
    }
}
