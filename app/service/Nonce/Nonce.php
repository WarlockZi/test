<?php

namespace app\service\Nonce;

class Nonce
{
    private static Nonce $instance;

    private static $nonce;
    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new Nonce();
        self::generate();
        return self::$instance;
    }

    private static function generate(): void
    {
        self::$nonce =  base64_encode(random_bytes(16));
    }
    public static function getNonce()
    {
        $ist = self::getInstance();

        if (!$ist::$nonce) {
            self::generate();
        }
        return self::$nonce;
    }

}