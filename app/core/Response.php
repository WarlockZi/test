<?php

namespace app\core;

class Response
{
    public static function exitJson(array $arr = []): void
    {
        if ($arr) {
            exit(json_encode(['arr' => $arr]));
        }
    }

    public static function exitWithPopup(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['popup' => $msg]));
        }
        exit();
    }
    public static function dbResponse(): void
    {

    }

    public static function exitWithMsg(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['msg' => $msg]));
        }
        exit();
    }

    public static function exitWithSuccess(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['success' => $msg]));
        }
        exit();
    }

    public static function exitWithError(string $msg): void
    {
        if ($msg) {
            exit(json_encode(['error' => $msg]));
        }
        exit();
    }

}