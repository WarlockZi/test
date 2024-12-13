<?php

namespace app\Repository;

use app\core\FS;

class MaiRepository
{
    public static function forgotPassword(array $props): array
    {
        return [
            0 => ROOT . FS::platformSlashes("/app/core/Mail/consoleMail.php"),
            1 => $props[0]->email,
            2 => 'VITEX|новый пароль',
            3 => 'Ваш новый пароль - '.$props[1],
        ];
        return [
            'path' => ROOT . FS::platformSlashes("/app/core/Mail/consoleMail.php"),
            'to' => $props[0]->email,
            'subject' => 'test',
            'body' => 'body text and other',
        ];
    }

    protected function setHeaders(string $type): void
    {
        $additionalHeaders = '';
        if ($type = 'html') {
            $additionalHeaders = [
                'MIME-Version' => '1.0',
                'Content-type' => ' text/html; charset=UTF-8',
            ];
            $this->headers     = array_merge($this->headers, $additionalHeaders);
        }
    }

}