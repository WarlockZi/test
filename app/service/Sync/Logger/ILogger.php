<?php

namespace app\service\Sync\Logger;

interface ILogger
{
    public function log(string $message): void;
    public function error(string $message): void;
    public function info(string $message): void;
}